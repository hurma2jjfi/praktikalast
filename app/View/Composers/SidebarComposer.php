<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class SidebarComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $chats = Chat::where('user1_id', $user->id)
                ->orWhere('user2_id', $user->id)
                ->with('messages') // Eager Loading сообщений
                ->get();

            $totalUnreadCount = 0;
            foreach ($chats as $chat) {
                $totalUnreadCount += $chat->messages->filter(function ($message) use ($user) {
                    return $message->read_at === null && $message->user_id !== $user->id;
                })->count();
            }

            $view->with('totalUnreadCount', $totalUnreadCount);
        } else {
            $view->with('totalUnreadCount', 0);
        }
    }
}
