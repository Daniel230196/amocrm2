<?php


namespace core;


use entities\ExporterInterface;

/**
 * Интерфейс для генерации файлов
 **/
interface FileCreatorInterface
{
    /**
     * Основной метод создания файла
     * @param ExporterInterface $exporter
     * */
    public function create(ExporterInterface $exporter) : void;
}