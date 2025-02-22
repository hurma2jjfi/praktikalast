<?php

namespace App\Traits;

use Carbon\Carbon;

trait UserActivityStatus
{
    /**
     * Обновляет время последней активности пользователя.
     */
    public function updateLastActivity()
    {
        $this->last_activity_at = now();
        $this->is_online = true;
        $this->save();
    }

    /**
     * Проверяет, онлайн ли пользователь.
     */
    public function isOnline()
    {
        return $this->is_online && $this->last_activity_at > now()->subMinutes(5);
    }

    /**
     * Возвращает время последней активности в удобном формате.
     */
    public function lastSeen()
    {
        if ($this->isOnline()) {
            return 'Онлайн';
        }

        if (!$this->last_activity_at) {
            return 'Никогда не был в сети';
        }

        $now = now();
        $lastSeen = Carbon::parse($this->last_activity_at);

        // Разница в минутах
        $diffInMinutes = $now->diffInMinutes($lastSeen);

        // Если пользователь был в сети менее 1 минуты назад
        if ($diffInMinutes < 1) {
            return 'Был в сети только что';
        }

        // Если пользователь был в сети менее 60 минут назад
        if ($diffInMinutes < 60) {
            return "Был в сети $diffInMinutes " . $this->pluralize($diffInMinutes, ['минуту', 'минуты', 'минут']) . ' назад';
        }

        // Если пользователь был в сети сегодня
        if ($lastSeen->isToday()) {
            return 'Был в сети сегодня в ' . $lastSeen->format('H:i');
        }

        // Если пользователь был в сети вчера
        if ($lastSeen->isYesterday()) {
            return 'Был в сети вчера в ' . $lastSeen->format('H:i');
        }

        // Если пользователь был в сети на этой неделе
        if ($lastSeen->isCurrentWeek()) {
            return 'Был в сети в ' . $lastSeen->translatedFormat('l в H:i'); // Например, "в понедельник в 15:30"
        }

        // Если пользователь был в сети больше недели назад
        return 'Был в сети ' . $lastSeen->translatedFormat('j F Y в H:i'); // Например, "5 октября 2023 в 20:00"
    }

    /**
     * Склоняет слова в зависимости от числа.
     */
    private function pluralize(int $number, array $titles)
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}