<?php

namespace controllers;

use core\Request;


/*
 * Главный контроллер приложения
 * */
class Controller
{
    /*
     * View контроллера
     * */
    protected string $view;
    /*
     * Экземпляр запроса
     * */
    protected Request $request;
    /*
     * Путь к view-файлам
     * */
    protected string $viewPath = 'view/';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function render()
    {
        include $this->viewPath.$this->view.'.php';
    }
}