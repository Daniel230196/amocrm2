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

        if (!preg_match('/dann70s\.amocrm\.ru/', $_SERVER['HTTP_REFERER']) != false) {
            echo $_SERVER['HTTP_REFERER'];
            exit();
        }

        $file = file_get_contents(__DIR__ . '/../core/files/list.csv');
        header('Access-Control-Allow-Origin: https://dann70s.amocrm.ru');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=leads.csv');
        header("Accept-Ranges: bytes");
        //header("Content-Length: " . filesize($file));

        echo $file;
    }

}