<?php


namespace entities;


use core\ApiConnection;

/*
 * Класс , предназн для заполнения кастомных полей сущностей
 */
class CustomField implements FIllableInterface
{
    public int $entityId;
    public int $id;
    public string $type;
    public array $data;
    public $paramsData;

    /*
     * Массив соответствия (сущность => Id поля типа текст)
     * */
    protected array $fields = [
        'leads' => 523675,
        'companies' => 522609,
        'customers' => 523735,
        'contacts' => 522607,
    ];

    protected ApiConnection $api;

    public function __construct(array $params)
    {
        $this->entityId = $params['id'];
        $this->api= ApiConnection::getInstance();
        $this->type = $params['type'];
        $this->id = $this->fields[$this->type];
        $this->paramsData = $params['data'];
        $this->data = [
            'id' => $this->entityId,
            'custom_fields_values' => [[
                'field_id' => $this->id,
                'values' => [[
                    'value' => $this->paramsData
                ]]
            ]]
        ];
    }

    /*
     * метод возвращает данные для запроса
     * */
    public function getData() : array
    {
        return $this->data;
    }

    /*
    * Метод запроса к апи для изменения доп. поля текст
    * */
    public function patch()
    {
        return $this->api->patch($this);
    }

}