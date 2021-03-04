<?php


namespace entities;


use core\ApiConnection;

/**
 * Класс сущности задачи
 * */
class Task implements FIllableInterface
{
    /**
     * Массив данных запроса на добавление
     * */
    private array $data;

    /**
     * Массив данных запроса на редактирование
     * */
    private array $patchData;

    /**
     * ID Задачи
     * */
    public int $entityId;

    /**
     * Тип сущности
     * */
    public string $type = 'tasks';

    /**
     * Объект для соединения с API
     * */
    private ApiConnection $api;


    /**
     * Конструктор класса.
     * Генерирует данные для запроса, проверяя, должна-ли сущность быть создана
     * или завершена
     * @param array $data
     * */
    public function __construct(array $data)
    {
        if($data['result']){
            $this->patchData = [
                'is_completed' => true,
                'result' => [
                    'text' => $data['result']
                ]
            ];
            $this->entityId = intval($data['id']);
        }else{
            $this->data = [[
                'text' => $data['text'],
                'responsible_user_id' => intval($data['user']),
                'complete_till' => strtotime($data['time']),
                'entity_id' => intval($data['entity']),
                'entity_type' => $data['type']
            ]];
        }
        $this->api = ApiConnection::getInstance();
    }

    /**
     * Получить данные для добавления задачи
     * @return array
     * */
    public function getAddData() : array
    {
        return $this->data;
    }

    /**
     * Метод для добавления задачи
     * @return void
     * */
    public function add() : void
    {
        $this->api->addTask($this);
    }

    /**
     * Получить данные для редактирования задачи
     * @return array
     * */
    public function getData(): array
    {
        return $this->patchData;
    }

    /**
     * Метод для редактирования задачи
     * @return mixed
     * */
    public function patch()
    {
        return $this->api->patch($this);
    }
}