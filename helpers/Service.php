<?php
namespace app\helpers;


class Service
{
    static private $lastPageSessionKey = 'lastPage';

    public static function getLastPageSessionKey()
    {
        return self::$lastPageSessionKey;
    }

}