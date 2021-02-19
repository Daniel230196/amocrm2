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
    public function getData()
    {
        return $this->data;
    }
    /*
     * Получить запрашиваемый контроллер
     * */
    public function getContr(): string
    {
        return $this->explodeUri()[0];

    }
    /*
     * Получить запрашиваемый метод
     * */
    public function getMethod() : string
    {
        return $this->explodeUri()[1];
    }
    /*
     * Вспомогательная функция, разбивающая строку запроса
     * */
    private function explodeUri() : array
    {
       return  explode('/',$this->uri);
    }
}