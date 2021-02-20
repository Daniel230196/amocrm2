<?php


namespace entities;

/*
 * Базовый класс для создания примечаний
 * */

use core\ApiConnection;

class BaseNote
{
    /*
     * массив данных для запроса
     * */
    protected array $data;

    /*
     * ID Сущности
     * */
    protected int $entityId;

    /*
     *
     * */
    protected string $entityType;

    /*
     * Объект для соединения с АПИ
     * */
    protected ApiConnection $api;

    public function __construct(array $data)
    {
        $this->data = [[
            'entity_id' => $data['id'],
            'note_type' => $data['noteType'],
            'params' => []
        ]];
        $this->entityId = $data['id'];
        $this->entityType = $data['entityType'];
        $this->api = ApiConnection::getInstance();
    }

    /*
     * Метод добавляет примечание
     * */
    public function addNote()
    {
       return $this->api->addNote($this);
    }

    /*
     * получить тип сущонсти
     * */
    public function getType() : string
    {
        return $this->entityType;
    }

    /*
     * Получить данные запроса
     * */
    public function getData() : array
    {
        return $this->data;
    }
}