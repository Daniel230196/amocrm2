<?php


namespace core;

/**
 * Класс для обработки запросов
 * */
class Request
{
    /**
     * Данные запроса
     * */
    private array $data;

    /**
     * Строка запроса
     * */
    private string $uri;

    /**
     * Конструктор класса.
     * Фильтрация данных запроса, определение строки запроса
     * */
    public function __construct()
    {
        $this->data = filter_var_array($_REQUEST);
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
    }

    /**
     * Получить данные запроса
     * @return array
     * */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * Получить запрашиваемый контроллер
     * @return string
     **/
    public function getContr() : string
    {
        return $this->explodeUri()[1];

    }

    /**
     * Получить запрашиваемый метод
     * @return string
     **/
    public function getMethod() : string
    {
        $uri = isset($this->explodeUri()[2]) ? $this->explodeUri()[2] : 'default';

        return $uri !== 'default' ? explode('?',$uri)[0] : 'default';
    }

    /**
     * Вспомогательная функция, разбивающая строку запроса
     * @return array
     **/
    private function explodeUri() : array
    {
        return $this->uri === '/' ? ['', 'Controller', 'render'] : explode('/',$this->uri);
    }
}