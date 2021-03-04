<?php


namespace core;

/**
 * Интерфейс для организации связей покупателей
 **/
interface CustomerBinderInterface
{
    /**
     * Метод, организующий связь
     * @param array
     * @return void
     **/
    public function bindCustomers(array $apiResponse) : void;
}