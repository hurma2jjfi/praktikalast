<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Events\UserStatusUpdated;
use Illuminate\Support\Facades\Cache;

trait UserActivityStatus
{
    /**
     * Ключ для хранения статуса онлайн в кеше.
     */
    protected function getCacheKey(): string
    {
        return 'user-online-' . $this->id;
    }

    /**
     * Обновляет время последней активности пользователя и устанавливает статус онлайн в кеше.
     */
    public function updateLastActivity()
    {
        $this->last_activity_at = now();
        $this->save();

        Cache::put($this->getCacheKey(), true, now()->addMinutes(5));

        broadcast(new UserStatusUpdated($this))->toOthers();
    }

    /**
     * Проверяет, онлайн ли пользователь, используя кеш и базу данных.
     */
    public function isOnline(): bool
    {
        if (Cache::has($this->getCacheKey())) {
            return true; // Пользователь онлайн (есть запись в кеше)
        }

        // Если нет в кеше, проверяем last_activity_at в базе данных (альтернативный вариант)
        return $this->last_activity_at !== null && $this->last_activity_at > now()->subMinutes(5);
    }

    /**
     * Возвращает время последней активности в удобном формате.
     */
    public function lastSeen()
    {


        Carbon::setLocale('ru');

        if ($this->isOnline()) {
            return 'Онлайн';
        }

        if (!$this->last_activity_at) {
            return 'Никогда не был в сети';
        }

        $now = now();
        $lastSeen = Carbon::parse($this->last_activity_at);

        $lastSeen->setTimeZone('Europe/Moscow');

        // Разница в минутах
        $diffInMinutes = $now->diffInMinutes($lastSeen);

        // Если пользователь был в сети менее 1 минуты назад
        if ($diffInMinutes < 1) {
            return 'Был(а) в сети только что';
        }

        // Если пользователь был в сети менее 60 минут назад
        if ($diffInMinutes < 60) {
            return "Был(а) в сети $diffInMinutes " . $this->pluralize($diffInMinutes, ['минуту', 'минуты', 'минут']) . ' назад';
        }

        // Если пользователь был в сети сегодня
        if ($lastSeen->isToday()) {
            return 'Был(а) в сети сегодня в ' . $lastSeen->format('H:i');
        }

        // Если пользователь был в сети вчера
        if ($lastSeen->isYesterday()) {
            return 'Был(а) в сети вчера в ' . $lastSeen->format('H:i');
        }

        // Если пользователь был в сети на этой неделе
        if ($lastSeen->isCurrentWeek()) {
            return 'Был(а) в сети в ' . $lastSeen->translatedFormat('l в H:i'); // Например, "в понедельник в 15:30"
        }

        // Если пользователь был в сети больше недели назад
        return 'Был(а) в сети ' . $lastSeen->translatedFormat('j F Y в H:i'); // Например, "5 октября 2023 в 20:00"
    }

    /**
     * Склоняет слова в зависимости от числа.
     */
    private function pluralize(int $number, array $titles)
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    /**
     * Проверяет, был ли пользователь активен в течение последних N минут.
     */
    public function wasActiveRecently(int $minutes)
    {
        return $this->last_activity_at && $this->last_activity_at > now()->subMinutes($minutes);
    }

    /**
     * Возвращает время последней активности в формате даты и времени.
     */
    public function lastActivityDateTime()
    {
        if ($this->last_activity_at) {
            return Carbon::parse($this->last_activity_at)->translatedFormat('j F Y в H:i');
        } else {
            return 'Никогда не был в сети';
        }
    }

    /**
     * Возвращает время последней активности в формате только даты.
     */
    public function lastActivityDate()
    {
        if ($this->last_activity_at) {
            return Carbon::parse($this->last_activity_at)->translatedFormat('j F Y');
        } else {
            return 'Никогда не был в сети';
        }
    }

    /**
     * Возвращает время последней активности в формате только времени.
     */
    public function lastActivityTime()
    {
        if ($this->last_activity_at) {
            return Carbon::parse($this->last_activity_at)->format('H:i');
        } else {
            return 'Никогда не был в сети';
        }
    }

    /**
     * Возвращает статус онлайн/оффлайн в виде HTML-бейджа.
     */
    public function statusBadge()
    {
        if ($this->isOnline()) {
            return '<span class="badge bg-success">Онлайн</span>';
        } else {
            return '<span class="badge bg-secondary">Оффлайн</span>';
        }
    }

    /**
     * Возвращает статус онлайн/оффлайн в виде иконки.
     */
    public function statusIcon()
    {
        if ($this->isOnline()) {
            return '<i class="fa fa-circle text-success"></i>';
        } else {
            return '<i class="fa fa-circle text-secondary"></i>';
        }
    }

    /**
     * Обновляет статус пользователя как оффлайн (удаляет из кеша).
     */
    public function markAsOffline()
    {
        Cache::forget($this->getCacheKey());
        $this->is_online = false;
        $this->save();
    }

    /**
     * Проверяет, был ли пользователь активен в течение последних N часов.
     */
    public function wasActiveRecentlyHours(int $hours)
    {
        return $this->last_activity_at && $this->last_activity_at > now()->subHours($hours);
    }

    /**
     * Проверяет, был ли пользователь активен в течение последних N дней.
     */
    public function wasActiveRecentlyDays(int $days)
    {
        return $this->last_activity_at && $this->last_activity_at > now()->subDays($days);
    }
}
