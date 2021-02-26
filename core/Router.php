<?php


namespace core;

/*
 * Класс - роутер
 *
 * */
class Router
{
    /*
     * Дефолтный контроллер
     * */
    private static string $defaultController = 'ApiRequestController';

    /*
     * Неймспейс контроллера
     * */
    private static string $contrNamespace = '\\controllers\\';

    /*
     * Доступные маршруты по контроллерам
     * */
    public static array $routes = [
        'ApiRequestController' => ['create','text','note','task','taskComplete','test'],
        'WidgetController' => ['export', 'test']
    ];

    /*
     * Основной метод, определяет контроллер и его метод.
     * Вызывает дефолтный если запрос некорректен
     * */
    public static function start(Request $request)
    {
        $contr =  ucfirst($request->getContr());
        $contr = $contr.'Controller';
        $method = $request->getMethod();

        if(file_exists('controllers/'.$contr.'.php') && in_array($method,self::$routes[$contr])){
           $contr = self::$contrNamespace.$contr;
           $oContr = new $contr($request);
           $oContr->$method();
        } else {
            $contr = self::$contrNamespace.self::$defaultController;
            $oContr = new $contr($request);
            $oContr->render();
        }
    }
}