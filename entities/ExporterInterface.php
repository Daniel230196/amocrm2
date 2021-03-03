<?php


namespace entities;

/*
 * Интерфейс, для экспортируемых сущностей
 * */
interface ExporterInterface
{
    public function export();
    public function getAllData();
}