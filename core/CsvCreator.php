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

        $header = $data[0];

        foreach ($data as &$value){
            for($i = 0; $i < count($header); ++$i){
                $value[$i] = !isset($value[$i]) ? '' : $value[$i];
            }
            fputcsv($f, $value);
        }

        fclose($f);
    }

}