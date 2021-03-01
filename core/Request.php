<?php


namespace core;

/*
 * Класс для обработки запросов
 * */

class Request
{
    /*
     * Данные запроса
     * */
    private array $data;
    /*
     * Строка запроса
     * */
    private $uri;


    public function __construct()
    {
        $this->data = filter_var_array($_REQUEST);
        $this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    }

    /*
     * Получить данные запроса
     * */
    public function getData() : array
    {
        return $this->data;
    }

    /*
     * Получить запрашиваемый контроллер
     * */
    public function getContr() : string
    {
        return $this->explodeUri()[1];

    }

    /*
     * Получить запрашиваемый метод
     * */
    public function getMethod() : string
    {
        $uri = $this->explodeUri()[2];
        $uri = isset($uri) ? $uri: 'default';
        return $uri !== 'default' ? explode('?',$uri)[0] : 'default';
    }

    /*
     * Вспомогательная функция, разбивающая строку запроса
     * */
    private function explodeUri()
    {
        return $this->uri == '/' ? ['', 'Controller', 'render'] : explode('/',$this->uri);
    }
}