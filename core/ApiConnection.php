<?php

namespace core;

use entities\BaseNote;
use entities\CustomField;
use entities\FIllableInterface;
use entities\Task;


/*
 * Класс, выполняющий запросы к API
 * */
class ApiConnection
{
    private string $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUwNDI3YWI3MTMwMzI0MzFlOGVlZjEwM2M5NjljODRmMzEyYTFkZWY5ZTA3ODkyNGEwYWNmOTUwZDEzZTQ4MmQ4NDcwNTAzYjdjM2I0MWUyIn0.eyJhdWQiOiI2YTI0Y2YwZS02OGRjLTQ4ZWEtYjVjNS0zNDNmOTgxOGEwZDkiLCJqdGkiOiI1MDQyN2FiNzEzMDMyNDMxZThlZWYxMDNjOTY5Yzg0ZjMxMmExZGVmOWUwNzg5MjRhMGFjZjk1MGQxM2U0ODJkODQ3MDUwM2I3YzNiNDFlMiIsImlhdCI6MTYxNDE2NTg4NywibmJmIjoxNjE0MTY1ODg3LCJleHAiOjE2MTQyNTIyODcsInN1YiI6IjY3NjEwMTQiLCJhY2NvdW50X2lkIjoyOTMwMjM3NSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.HXftgi_XUU7iEhLf1oN8-ypJ1ibFBEL-_Rl_bXhEZguulVaU7hPXfrDs_iuXrllCGN5H22NwqRCElKTiPiwvBwbazE71ATbwNEIBDlah17ppaMamYXXZCXvchn8kuYQ3Mf-Z2SFDFSrEgnAJNfD-Bq-tqHemGyQ17181YIxSH-bhQmZukqYOE6-pmXC9ZDmxeF4Epul6KoHaXyrR7hRj1JQGbAjT3F1LzCvwww3Fg33XdSAYS_-kYaMLHqG0IkWJyVPx_H6K6xuKfQEGo1h9fVFbJqOavOHi-NHPA4dBW4-mCaoYaDj5Fp5fsJcmO6AIeI93kTtOxulmOhAG22gtvw';
    private string $refreshToken = 'def502008c4ab2a46eee4331ed04e35be9a566abb513c74937a8c23f01c11b6f5538789ae45e1f2d82aecccb872c308aad88f9ca86b12da64414cae880a64b36106f85a3072907dca15c46081494f24da2d621e003abaf78127e6cdea55e39f7049ead79d277b0834a3ccf8b8f4d332fb06a1bef3f16567adba98a469a182711ba26ecfb81e4f5f162bce78a3e80740fff9016675ca78477596dcf4a2e23e16e78c0c56c85fdd0cb526f6af7233efc18f3dd5cb984f75a690b9bef2b36c2dbabac008599f9f55c0bd3cdab36a723c6753c36baa484bb8d63b836a31f3694abd74520dfe31d21617e4b688f02ac4c006ae4305c71306e1656d5a52c0fc08f2d32942d0ae6518874077326ce8779dd737100782a780313934805cc6b75bba3e910a5a503175fc20e37c2209c1a4ba3c361ebd942104a468e0ad39d0a82a9f977021272456c7d9eebeaecdb40409ac89a42572b5fda117149d8ce84d4a60d005e32cb075fa9fb329ba0294e4f1a38af4e632ad9546516299242f502af33baaebf278dd4c159a5ff8221e8db08af1636d9d456215d3c4df10754c079762a57aa5942f7091d304f5fbb0df8dd2b23099d21b93f3ac6ab4b3536bf063df9836c66898e1e7cc0fbdff28e5e9167';
    private string $header = 'Authorization: Bearer ';
    private string $subdomain = 'https://dann70s.amocrm.ru/';
    private $curl;
    private static $connection;

    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    public static function getInstance() : ApiConnection
    {
        if (is_null(self::$connection)){
            self::$connection = new self();
            return self::$connection;
        } else {
            return self::$connection;
        }
    }

    /*
     * Метод, производящий curl-запросы
     *
     * */
    private function curlRequest(array $data, string $method, string $uri)
    {
        $link = $this->subdomain.$uri;
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

        $code = curl_getinfo($this->curl,CURLINFO_RESPONSE_CODE);
        $response = curl_exec($this->curl);
        curl_close($this->curl);

        return $response;
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