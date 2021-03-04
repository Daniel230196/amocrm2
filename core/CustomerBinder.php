<?php


namespace core;

/**
 * Класс для привязки покупателей к компаниям
 * */
class CustomerBinder implements CustomerBinderInterface
{
    /**
     * Экземпляр для соединеня с Api
     * */
    private ApiConnection $api;

     /**
     * Данные запроса
     * */
    private array $requestData;

    /**
     * Конструктор класса.
     * Инициализируется сущность для связи с API
     * */
    public function __construct()
    {
        $this->api = ApiConnection::getInstance();
    }

    /**
     * Основной метод
     * @param array $apiResponse
     * @return void
     * */
    public function bindCustomers(array $apiResponse) : void
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

        $this->api->bind($this);

    }

    /**
     * Метод возвращает данные для запроса
     * @return array
     * */
    public function getRequestData() : array
    {
        return $this->requestData;
    }

    /**
     * Метод возвращает массив ID покупателей
     * @param array $response
     * @return array
     * */
    private function customersId(array $response) : array
    {
        $Id = [];
        foreach ($response['_embedded']['customers'] as $value){
            $Id[] = $value['id'];
        }
        return $Id;
    }

    /**
     * Метод возвращает массив ID компаний
     * @param array $response
     * @return array
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