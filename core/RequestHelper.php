<?php


namespace core;

use core\test\ApiConnectionException;
use entities\CompaniesMaker;
use entities\ContactsMaker;
use entities\CustomerMaker;
use entities\LeadsMaker;

/**
 * Класс-посредник для выполнения комплексных запросов к АПИ
 * */
class RequestHelper implements ApiRequestInterface
{
    /**
     * Комплексный список всех сущностей
     * */
    private array $boundedList;

    /**
     * Список компаний для связи с покупателями
     * */
    private array $companyList;

    /**
     * Экземпляр связи с апи
     * */
    private ApiConnection $api;

    /**
     * Экземпляр CustomerBinderInterface
     * */
    private CustomerBinderInterface $binder;

    /**
     * Конструктор класса.
     * Генерация списка всех сущностей в соответсвии с запрашиваемым количеством
     * @param LeadsMaker $leadsMaker
     * @param CompaniesMaker $companiesMaker
     * @param ContactsMaker $contactsMaker
     * @param CustomerMaker $customerMaker
     * @param CustomerBinderInterface $binder
     * @param int $count
     * */
    public function __construct(
        LeadsMaker $leadsMaker,
        CompaniesMaker $companiesMaker,
        ContactsMaker $contactsMaker,
        CustomerMaker $customerMaker,
        CustomerBinderInterface $binder,
        int $count
    )
    {
        $this->binder = $binder;
        $this->api = ApiConnection::getInstance();
        $leadsData = $leadsMaker->makeList($count);
        $companiesData = $companiesMaker->makeList($count);
        $contactsData = $contactsMaker->makeList($count);
        $customersData = $customerMaker->makeList($count);

        $this->boundedList = $this->list($leadsData, $companiesData, $contactsData, $customersData);
    }


    /**
     * Основной метод класса. Производит цепочку запросов к АПИ
     * @return void
     * */
    public function addComplex() : void
    {
        $leads = $this->getLeads();
        $customers = $this->getCustomers();
        $x = count($leads);
        if ( $x >= 10){
            $leads = array_chunk($leads, 10);
            $customers = array_chunk($customers,10);

            $entities['leads'] = $leads;
            $entities['customers'] = $customers;

             for($i=0; $i<count($leads); ++$i){

                 $this->boundedList['leads'] = $leads[$i];
                 $this->boundedList['customers'] = $customers[$i];

                 // 3 запроса за вызов
                 $this->apiRequests();
                 usleep(600);
             }

        } else {
            $this->apiRequests();
        }

    }

    /**
     * Метод для получения списка всех покупателей
     * @return array
     * */
    public function getCustomers() : array
    {
        return $this->boundedList['customers'];
    }

    /**
     * Метод для получения комплексного списка сделок
     * @return array
     * */
    public function getLeads() : array
    {
        return $this->boundedList['leads'];
    }

    /**
     * Метод для добавления покупателей
     * @param array $response
     * @return void
     * */
    public function bindCustomers(array $response) : void
    {
        $this->binder->bindCustomers($response);
    }

    /**
     * Метод, возвращаюший полный список сущностей
     * @return array
     **/
    public function getBoundedList(): array
    {
        return $this->boundedList;
    }

    /**
     * Метод для получения общего комплексного списка сущностей
     * @param array $leadsData
     * @param array $companiesData
     * @param array $contactsData
     * @param array $customersData
     * @return array
     * */
    private function list(array $leadsData, array $companiesData, array $contactsData, array $customersData): array
    {
        foreach ($leadsData as &$lead) {
            $lead['_embedded']['companies'][] = array_pop($companiesData);
            $lead['_embedded']['contacts'][] = array_pop($contactsData);
            $this->companyList[] = $lead['_embedded']['companies'];
        }

        $result['leads'] = $leadsData;
        $result['customers'] = $customersData;

        return $result;
    }

    /**
     * Метод, который производит 3 основных запроса к АПИ
     * @return void
     * */
    private function apiRequests() : void
    {
        try{
            $responseLeads = $this->api->addComplex($this);
            if($responseLeads === false){
                throw new ApiConnectionException('0', );
            }
            $responseCustomers = $this->api->addCustomers($this);

            $response = array_merge(json_decode($responseLeads, true), json_decode($responseCustomers, true));
            $this->bindCustomers($response);
        }catch(ApiConnectionException $e){
            echo $e->getMessage().$e->getCode();
            exit;
        }
    }

}