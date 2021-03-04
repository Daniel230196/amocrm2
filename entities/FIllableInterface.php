<?php


namespace entities;

/**
 * Интерфейс для полей, заполняемых методом PATCH
 * */
interface FIllableInterface
{
    /**
     * Метод, возвращающий данные для запроса
     * @return array
     * */
    public function getData() : array ;

    /**
     * Метод, производящий запрос на заполнение поля
     * @return mixed
     * */
    public function patch();
}