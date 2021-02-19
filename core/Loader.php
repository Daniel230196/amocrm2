<?php

namespace core;
/*
 * класс для автозагрузки
 *
 * */
class Loader
{
    /*
     * колбэк для spl_autoload
     * */
    public static function autoload($classname)
    {
        $classname = str_replace('\\', '/', $classname);
        require_once $classname.'.php';
    }
    /*
     * основная функция автозагрузки
     * */
    public static function start()
    {
        spl_autoload_register(__NAMESPACE__.'\Loader::autoload');
    }
}