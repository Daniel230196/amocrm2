<?php

namespace core;

use entities\BaseNote;
use entities\FIllableInterface;
use entities\Task;


/**
 * Класс, выполняющий запросы к API
 * */
class ApiConnection
{
    use SingletonTrait;
    /**
     * Данные необходимые для запроса
     *
     * */
    private static string $clientId;
    private static string $clientSecret;
    private static string $redirectUri;
    private static string $accessToken;
    private static string $refreshToken;
    const DOMAIN = 'https://dann70s.amocrm.ru/';
    const HEADER = 'Authorization: Bearer ';

    /**
     * Инстанс утилиты curl для запросов к апи
     * */
    private $curl;

    /**
     * Счетчик неудачных запросов
     * */
    private static int $count = 1;

    private function __construct()
    {
    }

    public function get(string $type, string $uri = null)
    {
        if (is_null($uri)) {
            $uri = 'api/v4/' . $type;
        }

        $method = 'GET';
        return $this->curlRequest($method, $uri);
    }

    /**
     * Метод, инициализирующий необходимые для соединения данные
     * @return void
     * */
    private static function init() : void
    {
        $conf = Config::getInstance()->get('api', ['access_token','refresh_token','redirect_uri','client_id','client_secret', 'domain']);
        self::$refreshToken = $conf['refresh_token'];
        self::$accessToken = $conf['access_token'];
        self::$redirectUri = $conf['redirect_uri'];
        self::$clientSecret = $conf['client_secret'];
        self::$clientId = $conf['client_id'];
    }

    /**
     * Метод для автоматического обновления access_token
     * @return array
     * */
    private function refreshToken() : array
    {
        $params = [
            "client_id" => self::$clientId,
            "client_secret" => self::$clientSecret,
            "grant_type" => "refresh_token",
            "refresh_token" => self::$refreshToken,
            "redirect_uri" => self::$redirectUri
        ];

        $link = self::DOMAIN.'oauth2/access_token';

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);

        Config::getInstance()->set('api',$response);

        self::init();

        return $response;

    }

    /**
     * Метод, производящий curl-запросы
     * @param string $method
     * @param string $uri
     * @param mixed $data
     * @return mixed
     *
     * */
    private function curlRequest(string $method, string $uri, array $data = null)
    {
        $link = self::DOMAIN . $uri;
        $headers = $this->getHeaders();

        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->curl, CURLOPT_URL, $link);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);

        if(!is_null($data)){
            $data = json_encode($data);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        }

        $response = curl_exec($this->curl);
        curl_close($this->curl);


        $check = json_decode($response,true);

        if(isset($check['status']) && $check['status'] === 401){
            // в случае статуса ошибки 401 произвести попытку обновить токен, увеличить счетчик на единицу
            $this->refreshToken();
            ++static::$count;
            // в зависимости от счетчика, поавторить запрос , либо вернуть false
            return static::$count > 1 ? false : $this->curlRequest($method, $uri, json_decode($data,true));
        }else{
            return $response;
        }

    }

    /**
     * Пакетное добавление сделок с привязанными контактами и компаниями
     * @param ApiRequestInterface $apiHelper
     * @return mixed
     * */
    public function addComplex(ApiRequestInterface $apiHelper)
    {
        $uri = 'api/v4/leads/complex';

        $data = $apiHelper->getLeads();
        $method = 'POST';

        return $this->curlRequest($method, $uri, $data);

    }

    /**
     * метод для добавления покупателей
     * @param ApiRequestInterface $apiHelper
     * @return mixed
     * */
    public function addCustomers(ApiRequestInterface $apiHelper)
    {
        $uri = 'api/v4/customers';
        $method = 'POST';
        $data = $apiHelper->getCustomers();

        return $this->curlRequest($method,$uri, $data);
    }

    /**
     * Метод для связывания сущностей
     * @param CustomerBinderInterface $binder
     * @return mixed
     * */
    public function bind(CustomerBinderInterface $binder)
    {
        $uri = 'api/v4/companies/link';
        $method = 'POST';
        $data = $binder->getRequestData();

        return $this->curlRequest($method,$uri,$data);
    }

    /**
     * Метод заполняет редактирует сущность
     * @param FIllableInterface $model
     * @return mixed
     * */
    public function patch(FIllableInterface $model)
    {
        $uri = 'api/v4/' . $model->type . '/' . $model->entityId;
        $method = 'PATCH';
        $data = $model->getData();

        return $this->curlRequest($method,$uri,$data);
    }

    /**
     * Метод добавляет примечание
     * @param BaseNote $note
     * @return mixed
     * */
    public function addNote(BaseNote $note)
    {
        $uri = 'api/v4/' . $note->getType() . '/notes';
        $data = $note->getData();
        $method = 'POST';

        return $this->curlRequest($method, $uri, $data);


    }

    /**
     * Метод добавляет задачу
     * @param Task $task
     * @return mixed
     * */
    public function addTask(Task $task)
    {
        $uri = 'api/v4/tasks';
        $method = 'POST';
        $data = $task->getAddData();

        return $this->curlRequest($method,$uri,$data);
    }

    /**
     * метод получения необходимых для запроса заголовков
     * @return array
     * */
    private function getHeaders() : array
    {
        $headers[] = self::HEADER.self::$accessToken;
        $headers[] = 'Content-Type: application/json';
        return $headers;
    }


}