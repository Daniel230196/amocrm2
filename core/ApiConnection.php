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
    private string $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg0MjhlZWMwZjkxZjM1NDFmNjVjZTJiOGMwMDA2OTg1MTIzZWE3ZDQyOTE0MTYwMzBmYWFhOGJjMTU0MjRlYjdlZDQxOGE0OWJiOWJiZWIzIn0.eyJhdWQiOiI3YTExODRlMy0yZjA1LTQ3NjQtYTBlNy04MzIyNjNmZGYwZjUiLCJqdGkiOiI4NDI4ZWVjMGY5MWYzNTQxZjY1Y2UyYjhjMDAwNjk4NTEyM2VhN2Q0MjkxNDE2MDMwZmFhYThiYzE1NDI0ZWI3ZWQ0MThhNDliYjliYmViMyIsImlhdCI6MTYxNDEwOTA2MywibmJmIjoxNjE0MTA5MDYzLCJleHAiOjE2MTQxOTU0NjMsInN1YiI6IjY3NjEwMTQiLCJhY2NvdW50X2lkIjoyOTMwMjM3NSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.bVSG1T6LmX6IcoTjjba1RtuLDmc2BoOUn0zWJy3sjSZ8_tcwBW0MTClqK42vhCSCFMIBOXFUK-RRrPTxbVks-1WVne8jccxCnC8rjiaSVAhWCV6q6VJGg6th3_UH1QRN0ff5M5AxwQqM0cx-sLImye4tLga6Zw5XpeNt5txGkqdDAyAHFqPz-DyioMOVSMngw-0ZooiWWiFhVFhrKxSRN25wEsVOeRiVWo5FMIoU_gDVmEQ41wbWZ6uoMOuLDMv_2tHvaQJ7kFfe4OZZv5_KxoL6XdYJl037hSNkZBaXjELBhrIn_4LosFZrjpG_gTKLkv-8vL-SU3iOAZi_YpczIg';
    private string $refreshToken = 'def50200896542dfa50114304c2cf603636509b2c5244eea8f99d22fe7bd1c390a7bcbb06e74617ee4390d96e6680449928cd685ffa6094166a53e4ca8b9d20a8619409faf4b3494e0f80a05d1cb9e94b0d4d33984f222a03fe377c1772d422fbf56d6536d635d6636169cedfe35ae38459b32e4d7cc9203907f52c82da62bf87ab9f4f7a938266855ccd9f9148e20536a18ed94a4cc23fe1b4b4ce02d866d2e2b81c7c4a88dd603c498a7f6701f126189afe68c6900949841e5c63ba9708b5ed17a750d0cbb5559d30269ebb8828c9f9d216db5c05b5730e78092495ee980fb3ef128349f3522986d451c4e75437c7456f51e88ac3e20e429c234fccfe0b68e3724a8ebec24cd8ce9b193d9cf7956e818cbbdda90106044704f3cc155b5d73b09e92ac97a6e995f103d7854b579b82b690f297cdf819498568683a629de6f278e208e58be04749b9396ac6eb3707fcdc211a5aea3900d542bad45eafebfcf95574d5dbb03a801fe2e41ffcba4093dac73b7569832424bd87f4ee44d869b9320aadb16e5642e5533b08e7213f5b3cbdc6caaf08eb51944607ab003c87406b66ce3d6a12969ed7303dbb0f05b72f8cb7d3ae30a029b8c88854b656fa5cc3be375878662c41f1ddcbaad59';
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