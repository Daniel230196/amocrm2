<?php


namespace entities;

use core\ApiConnection;

/**
 * Базовый класс для создания примечаний
 * */
class BaseNote
{
    /**
     * массив данных для запроса
     * */
    protected array $data;

    /**
     * ID Сущности
     * */
    protected int $entityId;

    /**
     * Тип сущности, в которую будет добавляться заметка
     * */
    protected string $entityType;

    /**
     * Объект для соединения с АПИ
     * */
    protected ApiConnection $api;

    /**
     * Конструктор класса
     * @param array $data
     * */
    public function __construct(array $data)
    {
        $this->data = [[
            'entity_id' => intval($data['id']),
            'note_type' => $data['noteType'],
            'params' => []
        ]];
        $this->entityId = intval($data['id']);
        $this->entityType = $data['entityType'];
        $this->api = ApiConnection::getInstance();
    }

    /**
     * Метод добавляет примечание
     * @return void
     * */
    public function addNote() : void
    {
        $this->api->addNote($this);
    }

    /**
     * Получить тип сущонсти
     * @return string
     * */
    public function getType() : string
    {
        return $this->entityType;
    }

    /**
     * Получить данные запроса
     * @return array
     * */
    public function getData() : array
    {
        return $this->data;
    }
}