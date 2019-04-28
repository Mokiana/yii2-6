<?php

namespace app\helpers;


class Date
{
    public static function convertFromFormatToString($value, $empty = '', $format = 'Y-m-d')
    {
        if(is_string($value)) {
            $date = \DateTime::createFromFormat($format, $value);
            if(!$date) {
                return $empty;
            }
            return $date->format('d.m.Y');
        }
        return $empty;
    }
}