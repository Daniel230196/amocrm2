<?php


namespace controllers;

use core\CustomerBinder;
use core\Request;
use core\RequestHelper;
use entities\CompaniesMaker;
use entities\ContactsMaker;
use entities\CustomerMaker;
use entities\LeadsMaker;
use entities\Task;
use entities\TextField;
use entities\CommonNote;
use entities\IncallNote;
use http\Params;

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

    /*
     * Метод добавляет и связывает сущности
     * */
    public function create()
    {
        $countOfEntities = $this->request->getData()['count'];
        $apiHelper = new RequestHelper(
            new LeadsMaker(),
            new CompaniesMaker(),
            new ContactsMaker(),
            new CustomerMaker(),
            new CustomerBinder(),
            $countOfEntities
        );

        $apiHelper->addComplex();
    }

    /*
     * Метод добавляет примечание
     * */
    public function note()
    {
        $data = $this->request->getData();

        if ($data['noteType'] === 'common' ){
            $note = new CommonNote($data);
        } else {
            $note = new IncallNote($data);
        }
        $res = $note->addNote();
        var_dump($res);
    }

    /*
     * Метод добавляет доп поле текст
     * */
    public function text()
    {
        $data = $this->request->getData();
        var_dump($data);
        $textField = new TextField($data);
        $result = $textField->patch();
        var_dump($result);

    }

    /*
     * Метод добавляет новую задачу
     * */
    public function task()
    {
        $data = $this->request->getData();
        $task = new Task($data);
        $res = $task->add();
        var_dump($res);
    }

    /*
     * Метод, завершающий задачу
     * */
    public function taskComplete()
    {
        $data = $this->request->getData();
        $task = new Task($data);
        $res = $task->patch();
        var_dump($res);
    }
}