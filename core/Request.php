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
        $this->uri = $_SERVER['REQUEST_URI'];
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
    public function getContr()
    {
        return $this->explodeUri()[1];

    }
    /*
     * Получить запрашиваемый метод
     * */
    public function getMethod()
    {
        $uri = $this->explodeUri()[2];
        return explode('?',$uri)[0];
    }
    /*
     * Вспомогательная функция, разбивающая строку запроса
     * */
    private function explodeUri()
    {
       return  explode('/',$this->uri);
    }
}