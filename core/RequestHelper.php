<?php


namespace core;

/*
 * Класс-посредник
 * */

use entities\CompaniesMaker;
use entities\ContactsMaker;
use entities\LeadsMaker;

class RequestHelper implements ApiRequestInterface
{
    private array $boundedList;
    private ApiConnection $api;
    public function __construct(
                                    LeadsMaker $leadsMaker,
                                    CompaniesMaker $companiesMaker,
                                    ContactsMaker $contactsMaker,
                                    int $count
                                )
    {
        $this->api = ApiConnection::getInstance();
        $leadsData = $leadsMaker->makeList($count);
        $companiesData = $companiesMaker->makeList($count);
        $contactsData = $contactsMaker->makeList($count);
        $this->boundedList = $this->bindLeads($leadsData,$companiesData,$contactsData);
    }

    public function addComplex()
    {

        return $this->api->addComplex($this);

    }

    public function bindLists() : array
    {
        return $this->boundedList;
    }

    public function getById()
    {
        echo 'test';
    }

    private function bindLeads(array $leadsData, array $companiesData, array $contactsData) : array
    {
        foreach($leadsData as &$lead){
            $lead['_embedded']['companies'][] = array_pop($companiesData);
            $lead['_embedded']['contacts'][] = array_pop($contactsData);
        }
        return $leadsData;
    }
}