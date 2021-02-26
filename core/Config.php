<?php


namespace core;

/*
 * Класс настроек
 * */
class Config
{
    use SingletonTrait;

    /*
     * Массив с настройками
     * */
    private static array $config;

    /*
     * Путь к файлам конфигурации
     * */
    private static string $confPath;

    /*
     * Получить массив настроек по типу и ключам
     * */
    public function get(string $type, array $names) : array
    {
        $names = array_flip($names);
        return array_intersect_key(self::$config[$type], $names);
    }

    /*
     * Переписать конфигурацию новыми значениями
     * */
    public function set(string $type, array $newConfigElements)
    {
        if(array_key_exists($type,static::$config )){
           foreach(static::$config[$type] as $key=>&$value){
               $value = array_key_exists($key, $newConfigElements) ? $newConfigElements[$key] : $value;
           }
        }
        file_put_contents(self::$confPath.$type.'.json', json_encode(static::$config[$type], JSON_PRETTY_PRINT));
    }

    /*
     * Инициализация конфигураций
     * */
    public static function init() : array
    {
        self::$confPath = dirname(__FILE__).'/../../config/';
        $path = self::$confPath;
        $confFiles = scandir($path);
        $confFiles =  array_diff($confFiles, ['.','..']);

        foreach ($confFiles as $key=>&$value){
            $content = file_get_contents($path.$value);
            $pos = strrpos($value,'.');
            $value = substr($value, 0, $pos);
            self::$config[$value] = json_decode($content, true);
        }
        return self::$config;

    }

}