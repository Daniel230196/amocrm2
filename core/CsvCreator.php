<?php


namespace core;


use entities\ExporterInterface;

/*
 * Класс, формирующий csv-файл
 * */
class CsvCreator implements FileCreatorInterface
{
    /*
     * Метод, создающий файл в формате Csv
     * */
    public function create(ExporterInterface $exporter)
    {
        $f = fopen(__DIR__.'/files/list.csv', 'w');
        $data = $exporter->getAllData();

        foreach ($data as &$value){

            fputcsv($f, $value);
        }
        fclose($f);
    }

}