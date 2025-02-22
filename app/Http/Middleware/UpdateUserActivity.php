<?php

namespace App\Http\Middleware; // Обновите пространство имен

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserActivity
{
    public function handle(Request $request, Closure $next)
{
    if (Auth::check()) {
        $user = Auth::user();
        if (method_exists($user, 'updateLastActivity')) {
            $user->updateLastActivity();
        } else {
            // Логируем ошибку, если метод не найден
            Log::error('Метод updateLastActivity не найден в модели User');
        }
    }

    return $next($request);
}
}