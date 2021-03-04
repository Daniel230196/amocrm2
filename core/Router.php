<?php


namespace core;

/**
 * Класс - роутер
 *
 * */
class Router
{
    /**
     * Дефолтный контроллер
     * */
    const DEFAULT_CONTROLLER = 'ApiRequestController';

    /**
     * Неймспейс контроллера
     * */
    const CONTR_NAMESPACE = '\\controllers\\';

    /**
     * Доступные маршруты по контроллерам
     * */
    public static array $routes = [
        'ApiRequestController' => ['create','text','note','task','taskComplete','test'],
        'WidgetController' => ['export', 'download']
    ];

    /**
     * Основной метод, определяет контроллер и его метод.
     * Вызывает дефолтный если запрос некорректен
     * @param Request $request
     * @return void
     * */
    public static function start(Request $request) : void
    {
        $contr =  ucfirst($request->getContr());
        $contr = $contr.'Controller';
        $method = $request->getMethod();

        if(file_exists('controllers/'.$contr.'.php') && in_array($method,self::$routes[$contr])){
           $contr = self::CONTR_NAMESPACE.$contr;
           $oContr = new $contr($request);
           $oContr->$method();
        } else {
            $contr = self::CONTR_NAMESPACE.self::DEFAULT_CONTROLLER;
            $oContr = new $contr($request);
            $oContr->render();
        }
    }
}