<?php

namespace controllers;

use core\Request;


/**
 * Основной контроллер приложения
 * */
class Controller
{
    /**
     * View контроллера
     * */
    protected string $view;

    /**
     * Экземпляр запроса
     * */
    protected Request $request;

    /**
     * Путь к view-файлам
     * */
    const VIEW_PATH = 'view/';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function render()
    {
        include self::VIEW_PATH.$this->view.'.php';
    }
}