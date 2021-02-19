<?php


namespace controllers;


use core\Request;

class ApiRequestController extends Controller
{
    /*
     * Контроллер запросов к АПИ
     * */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function addList()
    {
        $this->request->getData();
    }
}