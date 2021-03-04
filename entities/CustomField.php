<?php


namespace entities;


use core\ApiConnection;

/**
 * Класс , предназн для заполнения кастомных полей сущностей
 **/
class CustomField implements FIllableInterface
{
    public int $entityId;

    /**
     * ID Кастомного поля, в соответствии с типом сущности
     * */
    public int $id;

    /**
     * Тип сущности
     * */
    public string $type;

    /**
     * Массив данных для запроса к API
     * */
    public array $data;

    /**
     * Значения кастомных полей
     * */
    public $paramsData;

    /**
     * Массив соответствия (сущность => Id поля типа текст)
     * */
    protected array $fields = [
        'leads' => 800693,
        'companies' => 522609,
        'customers' => 523735,
        'contacts' => 522607,
    ];

    protected ApiConnection $api;

    /**
     * Конструктор класса
     * производит форматирование данных для запроса
     * @return array $params
     * */
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

    /**
     * Метод возвращает данные для запроса
     * @return array
     * */
    public function getData() : array
    {
        return $this->data;
    }

    /**
    * Метод запроса к апи для изменения доп. поля текст
    * @return void
    * */
    public function patch() : void
    {
         $this->api->patch($this);
    }

}