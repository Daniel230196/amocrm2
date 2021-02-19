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
    private static string $defaultController;
    /*
     * Неймспейс контроллера
     * */
    private static string $contrNamespace;
    /*
     * Доступные маршруты по контроллерам
     * */
    private static array $routes = [
        ''
    ];
    /*
     * Основной метод, определяет контроллер и его метод.
     * Вызывает дефолтный если запрос некорректен
     * */
    public static function start(Request $request)
    {
        echo $request->getContr();
        echo 'works';
    }
}