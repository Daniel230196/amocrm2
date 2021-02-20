<?php

namespace core;

use \entities\EntityMaker;

class ApiConnection
{
    private string $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM0NmNiM2FhNDA0NjVjN2JiMmU1NzgzNDllNWFhNTMxNmRmYzRmMDVkZjVhMWE1ODlhZGVhZWVlMmVhZmJjY2ZlZWViNDc3MjFlMmY2N2FhIn0.eyJhdWQiOiJkMzA5MjkyNy1lY2Y4LTRlZjQtODdkOS00ODA1NTc3ZDVjNWQiLCJqdGkiOiJjNDZjYjNhYTQwNDY1YzdiYjJlNTc4MzQ5ZTVhYTUzMTZkZmM0ZjA1ZGY1YTFhNTg5YWRlYWVlZTJlYWZiY2NmZWVlYjQ3NzIxZTJmNjdhYSIsImlhdCI6MTYxMzY0NzcwOCwibmJmIjoxNjEzNjQ3NzA4LCJleHAiOjE2MTM3MzQxMDgsInN1YiI6IjY3NjEwMTQiLCJhY2NvdW50X2lkIjoyOTMwMjM3NSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.WJF59xABYn6eSHyNr49imumDFoLm6xmifvEnY-piYpeJZXr3sfCBWjFfSHrHgIP9SrqhkYt4T3HA74TjZqfMLl59l8c8bLM27TOR-G1-ITM2TYEaztTSvD_nONMHLIEzdLFKaZjBHxj3GH-yxyk4JxUXm-u38-8R118C_mxjY_vKx3K3isTz1JhuABxyS6Bp7i9yId1dQYA9zBCB4618fo7MPCEad_iClHqApfP3KSX8W8LBcj8RcEnAS363ZTSiXwTwi_l5y7kB6_tYfyoGb9xXe0XNslcUOTkNyXv53h5h2xmIj8N9cVtlij03hPNShf2WCYVbV7Lq2Hw7pUo6Sg';
    private string $refreshToken = 'def50200896542dfa50114304c2cf603636509b2c5244eea8f99d22fe7bd1c390a7bcbb06e74617ee4390d96e6680449928cd685ffa6094166a53e4ca8b9d20a8619409faf4b3494e0f80a05d1cb9e94b0d4d33984f222a03fe377c1772d422fbf56d6536d635d6636169cedfe35ae38459b32e4d7cc9203907f52c82da62bf87ab9f4f7a938266855ccd9f9148e20536a18ed94a4cc23fe1b4b4ce02d866d2e2b81c7c4a88dd603c498a7f6701f126189afe68c6900949841e5c63ba9708b5ed17a750d0cbb5559d30269ebb8828c9f9d216db5c05b5730e78092495ee980fb3ef128349f3522986d451c4e75437c7456f51e88ac3e20e429c234fccfe0b68e3724a8ebec24cd8ce9b193d9cf7956e818cbbdda90106044704f3cc155b5d73b09e92ac97a6e995f103d7854b579b82b690f297cdf819498568683a629de6f278e208e58be04749b9396ac6eb3707fcdc211a5aea3900d542bad45eafebfcf95574d5dbb03a801fe2e41ffcba4093dac73b7569832424bd87f4ee44d869b9320aadb16e5642e5533b08e7213f5b3cbdc6caaf08eb51944607ab003c87406b66ce3d6a12969ed7303dbb0f05b72f8cb7d3ae30a029b8c88854b656fa5cc3be375878662c41f1ddcbaad59';
    private $header = 'Authorization: Bearer ';
    private string $subdomain = 'https://dann70s';
    private $curl;
    private static ApiConnection $connection;

    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    public static function getInstance() : ApiConnection
    {
        if (empty (self::$connection)){
            return new self();
        } else {
            return self::$connection;
        }
    }

    public function linkEntities()
    {

    }

    /*
     * Метод для добавления пакета сущностей
     * */
    public function addEntity(EntityMaker $entity)
    {

        $link = $this->subdomain . $entity->getPath();

        $data = json_encode($entity->getData());

        $this->curl = curl_init();

        $this->configCurl();

        curl_setopt($this->curl, CURLOPT_URL, $link);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

        $out = curl_exec($this->curl);
        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        curl_close($this->curl);

        return $out;

    }

    public function addComplex(\core\RequestHelper $requestHelper)
    {
        $this->curl = curl_init();

        $data = $requestHelper->bindLists();
        $link = $this->subdomain.'/api/v4/leads/complex';
        var_dump($data);
        $headers[] = $this->header . $this->accessToken;

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->curl, CURLOPT_URL, $link);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));

        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        return $out = curl_exec($this->curl);
    }

    /*
     * Метод для связывания сущностей
     * */
    public function bind()
    {
        $this->configCurl();
    }

    /*
     * Метод для общего конфигурирования Curl
     *
     * */
    private function configCurl(): void
    {



    }

    public function apiRequest(Entity $entity)
    {

    }
}