<?php


namespace controllers;


use core\CsvCreator;
use entities\LeadsExporter;

/**
 * Контроллер запросов из виджета
 * */
class WidgetController extends Controller
{

    /**
     * Метод экспорта сделок в формат CSV
     * @return void
     * */
    public function export() : void
    {
        header('Access-Control-Allow-Origin: https://dann70s.amocrm.ru');
        $data = $this->request->getData();
        $test = new LeadsExporter($data, new CsvCreator());
        $test->export();

    }

    /**
     * Метод, отдающий csv файл с сервера
     * @return void
     * */
    public function download() : void
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

        echo $file;
    }

}