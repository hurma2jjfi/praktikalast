<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    /**
     * Обновляет время последней активности пользователя.
     */
    public function updateActivity()
    {
        $user = Auth::user();

        if ($user) {
            $user->updateLastActivity();
            return response()->json(['message' => 'Activity updated'], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
