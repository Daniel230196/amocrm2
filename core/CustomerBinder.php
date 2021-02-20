<?php


namespace core;

/*
 * Класс для привязки покупателей к компаниям
 * */
class CustomerBinder implements CustomerBinderInterface
{
    /*
     * Экземпляр для соединеня с Api
     * */
    private ApiConnection $api;

    /*
     * ID Компаний
     * */
    private array $companiesId;

    /*
     * ID Покупателей
     * */
    private array $customersId;

     /*
     * Данные запроса
     * */
    private array $requestData;

    public function __construct()
    {
        $this->api = ApiConnection::getInstance();
    }

    /*
     * Основной метод
     * */
    public function bindCustomers(array $apiResponse)
    {
        $companiesId = $this->companiesId($apiResponse);
        $customersId = $this->customersId($apiResponse);

        for($i=0; $i<count($companiesId);++$i){
            $this->requestData[] = [
                'entity_id' => $companiesId[$i],
                'to_entity_id'=> $customersId[$i],
                'to_entity_type' => 'customers'
            ];
        }

        $res = $this->api->bind($this);

        var_dump($res);
    }

    /*
     * Метод возвращает данные для запроса
     * */
    public function getRequestData() : array
    {
        return $this->requestData;
    }

    /*
     * Метод возвращает массив ID покупателей
     * */
    private function customersId(array $response) : array
    {
        $Id = [];
        foreach ($response['_embedded']['customers'] as $value){
            $Id[] = $value['id'];
        }
        return $Id;
    }

    /*
     * Метод возвращает массив ID компаний
     * */
    private function companiesId(array $response) : array
    {
        $Id = [];
        foreach ($response as $value){
            if( array_key_exists('company_id', $value) ) {
                $Id[] = $value['company_id'];
            } else {
                continue;
            }
        }
        return $Id;
    }
}