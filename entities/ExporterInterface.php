<?php


namespace entities;

/*
 * Интерфейс, для экспорта файла
 * */
interface ExporterInterface
{
    public function export();
    public function getAllData();
}