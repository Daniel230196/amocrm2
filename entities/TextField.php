<?php


namespace entities;

/*
 * Модель доп. поля текст
 * */

use core\ApiConnection;

class TextField extends CustomField
{


    public int $entityId;
    public array $data;


    public int $id;

    public string $type;

    protected $fields = [
        'leads' => 523675,
        'companies' => 522609,
        'customers' => 523735,
        'contacts' => 522607,
    ];

    public function __construct(array $params)
    {
        parent::__construct($params);
        var_dump($this->id);
    }

    /*
     * Метод запроса к апи для изменения доп. поля текст
     * */
    public function patch()
    {
        return $this->api->patch($this);
    }

    /*
     * Метод возвращает данные для запроса
     * */
    public function getData() : array
    {
        return $this->data;
    }
}