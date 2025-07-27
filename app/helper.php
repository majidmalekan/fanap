<?php

use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function config_path(string $path = ''): string
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}


if (!function_exists('convertPersianDateToLatin')) {
    /**
     * @param string $date
     * @return string
     */
    function convertPersianDateToLatin(string $date): string
    {
        return CalendarUtils::createCarbonFromFormat('Y-m-d', $date)
            ->format('Y-m-d');
    }
}

if (!function_exists('convertLatinDateToPersian')) {
    /**
     * @param string $date
     * @return string
     */
    function convertLatinDateToPersian(string $date): string
    {
        return Jalalian::fromDateTime($date)->format('Y/m/d H:i:s');
    }
}
