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
        /*$this->helper = new RequestHelper();*/
        $this->view = 'main';
        parent::__construct($request);
    }

    public function create()
    {
        $countOfEntities = $this->request->getData()['count'];
        $apiRequest = new RequestHelper(
            new LeadsMaker(),
            new CompaniesMaker(),
            new ContactsMaker(),
            $countOfEntities
        );
        var_dump($apiRequest->addComplex());

    }
}