<?php


namespace controllers;


use core\CsvCreator;
use entities\LeadsExporter;

/*
 * Контроллер запросов из виджета
 * */
class WidgetController extends Controller
{

    /*
     * Метод экспорта сделок в формат CSV
     * */
    public function export()
    {
        header('Access-Control-Allow-Origin: https://dann70s.amocrm.ru');
        $data = $this->request->getData();
        $test = new LeadsExporter($data, new CsvCreator());
        $test->export();

    }

    /*
     *
     * */
    public function download()
    {

        if ($_SERVER['HTTP_REFERER'] != 'https://dann70s.amocrm.ru/') {
            echo 404;
            exit();
        }

        $file = file_get_contents(__DIR__ . '/../core/testcsv/test.csv');
        header('Access-Control-Allow-Origin: https://dann70s.amocrm.ru');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=leads.csv');
        header("Accept-Ranges: bytes");
        header("Content-Length: " . filesize($file));

        echo $file;
    }

}