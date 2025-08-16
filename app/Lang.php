<?php
class Lang
{
    private static $messages = [];
    private static $locale = 'en';

    public static function setLocale($locale)
    {
        $path = __DIR__ . "/lang/{$locale}.php";
        if (file_exists($path)) {
            self::$messages = require $path;
            self::$locale = $locale;
        }
    }

    public static function get($key)
    {
        return self::$messages[$key] ?? $key;
    }
}
