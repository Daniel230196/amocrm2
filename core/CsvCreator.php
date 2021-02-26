<?php


namespace core;


use entities\ExporterInterface;

/*
 * Класс, формирующий csv-файл
 * */
class CsvCreator implements FileCreatorInterface
{

    public static function create(ExporterInterface $exporter)
    {
        $f = fopen(__DIR__.'/testcsv/test.csv', 'w');
        $data = $exporter->getAllData();
        $test = array_slice($data[2], 5);

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $test = [];

        foreach($data as &$value){
            for($i=0; $i<count($value); $i++){
                if(is_array($value[$i])){
                    var_dump($value[$i]);
                    array_map(function(&$el) use (&$test){
                        $test[] = $el;
                    }, $value[$i]);
                    unset($value[$i]);
                }
            }

        }
        var_dump($test);

        fclose($f);
    }

}