<?php


namespace core;

/**
 * Интерфейс для организации сложных комплексных запросов
 * */
interface ApiRequestInterface
{

    /**
     * Метод, отправляющий запрос на комплексное добавление сущностей
     * @return mixed
     * */
    public function addComplex();

    /**
     * Метод, организующий свящи сущностей между собой
     * @return array
     * */
    public function getBoundedList() : array;

    /**
     * Метод для организации связи покупателей с компаниями
     * @param array $response
     * @return mixed
     * */
    public function bindCustomers(array $response);
}