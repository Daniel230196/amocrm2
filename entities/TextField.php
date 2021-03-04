<?php


namespace entities;

/**
 * Модель доп. поля текст
 * */
class TextField extends CustomField
{
    public int $id;
    public string $type;

    public function __construct(array $params)
    {
        parent::__construct($params);

    }

}