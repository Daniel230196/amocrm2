<?php


namespace core;

use core\test\ApiConnectionException;
use entities\CompaniesMaker;
use entities\ContactsMaker;
use entities\CustomerMaker;
use entities\LeadsMaker;

/*
 * Класс-посредник для выполнения комплексных запросов к АПИ
 *
 * */
class RequestHelper implements ApiRequestInterface
{
    /*
     * Комплексный список всех сущностей
     * */
    private array $boundedList;

    /*
     * Список компаний для связи с покупателями
     * */
    private array $companyList;
    /*
     * Экземпляр связи с апи
     * */
    private ApiConnection $api;

    /*
     * Экземпляр CustomerBinderInterface
     * */
    private CustomerBinderInterface $binder;


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

    /*
     * Основной метод класса. Производит цепочку запросов к АПИ
     * */
    public function addComplex()
    {
        $leads = $this->getLeads();
        $customers = $this->getCustomers();

        $x = count($leads);
        if ( $x > 50) {
            $leads = array_chunk($leads, 50);
            $customers = array_chunk($customers,50);
             for($i=0; $i<=$x; ++$i){
                 $this->boundedList['leads'] = $leads[$i];
                 $this->boundedList['customers'] = $customers[$i];

                 // 3 запроса за вызов
                 $this->apiRequests();
                 usleep(500);
             }

        } else {
            $this->apiRequests();
        }

    }

    /*
     * Метод для получения списка всех покупателей
     * */
    public function getCustomers(): array
    {
        return $this->boundedList['customers'];
    }

    /*
     * Метод для получения комплексного списка сделок
     * */
    public function getLeads()
    {
        return $this->boundedList['leads'];
    }

    /*
     * Метод для добавления покупателей
     * */
    public function bindCustomers(array $response)
    {
        $this->binder->bindCustomers($response);
    }

    public function getBoundedList(): array
    {
        return $this->boundedList;
    }

    /*
     * Метод для получения общего комплексного списка сущностей
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

    /*
     * Метод, который производит 3 основных запроса к АПИ
     * */
    private function apiRequests()
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