<?php

namespace App\Helpers;

class DateHelper
{
    public static function getRelativeDate($date)
    {
        $now = now();
        $diff = $now->diffInDays($date);

        if ($diff == 0) {
            return 'Сегодня';
        } elseif ($diff == 1) {
            return 'Вчера';
        } else {
            return $date->format('F d'); // Добавляем число к месяцу
        }
    }
}