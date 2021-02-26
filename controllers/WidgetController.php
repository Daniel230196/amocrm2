<?php


namespace controllers;

/*
 * Контроллер запросов из виджета
 * */

use core\CsvCreator;
use entities\LeadsExporter;

class WidgetController extends Controller
{
    public function export()
    {
        $data = $this->request->getData();
        $test = new LeadsExporter($data, new CsvCreator());
        /*echo '<pre>';

        echo '</pre>';*/
        $test->export();
    }

    public function test()
    {
    }
}