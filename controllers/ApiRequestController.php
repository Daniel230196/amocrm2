<?php


namespace controllers;

use core\Request;
use core\RequestHelper;
use entities\CompaniesMaker;
use entities\ContactsMaker;
use entities\Leads;
use entities\LeadsMaker;

/*
 *
 * Контроллер запросов к АПИ
 * */
class ApiRequestController extends Controller
{
    /*
     * Посредник для организации запросов
     * */
    protected RequestHelper $helper;

    public function __construct(Request $request)
    {
        $this->view = 'main';
        parent::__construct($request);
    }

    public function create()
    {
        $countOfEntities = $this->request->getData()['count'];
        $apiHelper = new RequestHelper(
            new LeadsMaker(),
            new CompaniesMaker(),
            new ContactsMaker(),
            $countOfEntities
        );
        $test = $apiHelper->addComplex();
        var_dump($test);


    }
}