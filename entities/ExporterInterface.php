<?php


namespace entities;

/**
 * Интерфейс, для экспортируемых сущностей
 * */
interface ExporterInterface
{
    /**
     * Метод, производящий экспорт полей в файл
     * @return void
     * */
    public function export() : void;

    /**
     * Метод, возвращающий отформатированные данные
     * @return array
     * */
    public function getAllData() : array;
}