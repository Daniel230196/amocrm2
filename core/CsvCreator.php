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
        $f = fopen(__DIR__.'/testcsv/test.csv', 'w');
        $data = $exporter->getAllData();
        foreach($data as &$value){

            for($i = 0; $i <= count($value); ++$i){
                if(is_array($value[$i]) && count($value[$i]) > 0){
                    foreach ($value[$i] as $item){
                        $value[$i] = implode(' : ', $item);
                    }

                }elseif(is_array($value[$i]) && count($value[$i]) == 0 ){
                    $value[$i] = '';
                }
            }
            fputcsv($f, $value);

        }
        fclose($f);
    }

}