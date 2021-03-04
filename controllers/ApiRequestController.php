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


/**
 * Контроллер запросов к АПИ
 * */
class ApiRequestController extends Controller
{
    /**
     * Посредник для организации запросов
     * */
    protected RequestHelper $helper;

    /**
     * Конструктор класса
     * @param Request $request
     * */
    public function __construct(Request $request)
    {
        $this->view = 'main';
        parent::__construct($request);
    }

    /**
     * Метод добавляет и связывает сущности
     * @return void
     * */
    public function create() : void
    {
        $countOfEntities = $this->request->getData()['count'];

        if($countOfEntities > 10000 || $countOfEntities < 0) {
            $response['message'] = "invalid count of entities";
        }else{
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

    }

    /**
     * Метод добавляет примечание
     * @return void
     * */
    public function note() : void
    {
        $data = $this->request->getData();

        if ($data['noteType'] === 'common' ){
            $note = new CommonNote($data);
        } else {
            $note = new IncallNote($data);
        }
        $note->addNote();

    }

    /**
     * Метод добавляет доп поле текст
     * @return void
     * */
    public function text() : void
    {
        $data = $this->request->getData();
        $textField = new TextField($data);
        $textField->patch();

    }

    /**
     * Метод добавляет новую задачу
     * @return void
     * */
    public function task() : void
    {
        $data = $this->request->getData();
        $task = new Task($data);
        $task->add();
    }

    /**
     * Метод, завершающий задачу
     * @return void
     * */
    public function taskComplete() : void
    {
        $data = $this->request->getData();
        $task = new Task($data);
        $task->patch();

    }

}