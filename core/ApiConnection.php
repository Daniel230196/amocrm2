<?php

namespace core;

use entities\BaseNote;
use entities\FIllableInterface;
use entities\Task;


/*
 * Класс, выполняющий запросы к API
 * */
class ApiConnection
{
    use SingletonTrait;

    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;
    private string $accessToken;
    private string $refreshToken;
    private string $subdomain;
    private string $header = 'Authorization: Bearer ';
    private $curl;

    private function __construct()
    {
       $this->setConf();
    }

    /*
     * Метод, инициализирующий необходимые для соединения данные
     * */
    private function setConf()
    {
        $conf = Config::getInstance()->get('api', ['access_token','refresh_token','redirect_uri','client_id','client_secret', 'domain']);
        $this->refreshToken = $conf['refresh_token'];
        $this->accessToken = $conf['access_token'];
        $this->redirectUri = $conf['redirect_uri'];
        $this->subdomain = $conf['domain'];
        $this->clientSecret = $conf['client_secret'];
        $this->clientId = $conf['client_id'];
        var_dump($this);
    }
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /*
     * Метод для автоматического обновления access_token
     * */
    private function refreshToken()
    {
        $params = [
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "grant_type" => "refresh_token",
            "refresh_token" => $this->refreshToken,
            "redirect_uri" => $this->redirectUri
        ];

        $link = $this->subdomain.'oauth2/access_token';

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
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $out = json_decode($out, true);

        Config::getInstance()->set('api',$out);

        $this->setConf();


    }

    /*
     * Метод, производящий curl-запросы
     *
     * */
    private function curlRequest(array $data, string $method, string $uri)
    {
        $link = $this->subdomain . $uri;
        $headers = $this->getHeaders();
        $data = json_encode($data);
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->curl, CURLOPT_URL, $link);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $code = curl_getinfo($this->curl, CURLINFO_RESPONSE_CODE);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        $test = json_decode($response,true);

        if($test['status'] === 401){
            var_dump($test['status']);
            $this->refreshToken();
            return $this->curlRequest(json_decode($data,true),$method,$uri);
        }else{
            return $response;
        }

    }

    /*
     * Пакетное добавление сделок с привязанными контактами и компаниями
     * */
    public function addComplex(ApiRequestInterface $apiHelper)
    {
        $uri = 'api/v4/leads/complex';

        $data = $apiHelper->getLeads();
        $method = 'POST';

        return $this->curlRequest($data, $method, $uri);



    }

    /*
     * метод для добавления покупателей
     * */
    public function addCustomers(ApiRequestInterface $apiHelper)
    {
        $uri = 'api/v4/customers';
        $method = 'POST';
        $data = $apiHelper->getCustomers();

        return $this->curlRequest($data,$method,$uri);
    }

    /*
     * Метод для связывания сущностей
     * */
    public function bind(CustomerBinderInterface $binder)
    {
        $uri = 'api/v4/companies/link';
        $method = 'POST';
        $data = $binder->getRequestData();

        return $this->curlRequest($data,$method,$uri);
    }

    /*
     * Метод заполняет редактирует сущность
     *
     * */
    public function patch(FIllableInterface $model)
    {
        $uri = 'api/v4/' . $model->type . '/' . $model->entityId;
        $method = 'PATCH';
        $data = $model->getData();

        return $this->curlRequest($data, $method,$uri);
    }

    /*
     * Метод добавляет примечание
     * */
    public function addNote(BaseNote $note)
    {
        $uri = 'api/v4/' . $note->getType() . '/notes';
        $data = $note->getData();
        $method = 'POST';

        return $this->curlRequest($data, $method, $uri);


    }

    /*
     * Метод добавляет задачу
     * */
    public function addTask(Task $task)
    {
        $uri = 'api/v4/tasks';
        $method = 'POST';
        $data = $task->getAddData();

        return $this->curlRequest($data,$method,$uri);
    }

    public static function addCustomFieldText(string $entity)
    {
        $link ='https://dann70s.amocrm.ru/api/v4/' . $entity . '/custom_fields';

        $headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImE2Njg0ODg3MTA0YjQ2MDk3MTYzYTM2MGMxNGVmNzg3ZTY3NGM2YmU1YmViZTJhMDhlNzZlMzYzMDEzNmU5MGJjMzhjM2ZlMzQ2M2RmYjVhIn0.eyJhdWQiOiJkMzA5MjkyNy1lY2Y4LTRlZjQtODdkOS00ODA1NTc3ZDVjNWQiLCJqdGkiOiJhNjY4NDg4NzEwNGI0NjA5NzE2M2EzNjBjMTRlZjc4N2U2NzRjNmJlNWJlYmUyYTA4ZTc2ZTM2MzAxMzZlOTBiYzM4YzNmZTM0NjNkZmI1YSIsImlhdCI6MTYxMzc2OTIzNiwibmJmIjoxNjEzNzY5MjM2LCJleHAiOjE2MTM4NTU2MzYsInN1YiI6IjY3NjEwMTQiLCJhY2NvdW50X2lkIjoyOTMwMjM3NSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.Xrrh4Z1acORVLv36EyCcpXr-Te6IvSetpnnrMKrAvR-4gBaGpuqQaL6GmV6c_1u-uws4fH-I-xOzmzwt3bBW22FYXyAS7qT6kZtdMolOJAydiagPyw1Vx1TZpaSY4S1TmaBPlW9ZSxb2GcupyaOAENldWpO-0QonOXe3Z8aCBEjqp3rpgXX1YT2oVPRCTLdaUVwa6S5EL2WwtG29DZquda_CFV02cIqGhiqlYJd9cZndmxRFQrBjYkiimoFgCRzKsdfNx7pMzLq_mKZ2bGP9HENu5_cCvWINrMdEJjV-q8Toflpnureru9vvgUUgw1wh8Xxw8Q-IoGCpXLFzOV3Exg';
        $headers[] = 'Content-Type: application/json';
        //$data = json_encode($binder->getRequestData());

        $data = [[
                "name" => "text",
                "type" => "text",
            ]];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /*
     * метод получения необходимых для запроса заголовков
     * */
    private function getHeaders() : array
    {
        $headers[] = $this->header.$this->accessToken;
        $headers[] = 'Content-Type: application/json';
        return $headers;
    }


}