<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;

class FriendController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Получаем список друзей, исключая текущего пользователя
    $friends = Friend::where('status', 'Принято')
        ->where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('friend_id', $user->id);
        })
        ->get()
        ->map(function($friend) use ($user) {
            // Возвращаем объект с правильным другом
            return $friend->user_id === $user->id ? $friend->friend : $friend->user;
        });

    // Получаем входящие запросы на дружбу
    $friendRequests = Friend::where('friend_id', $user->id)
                             ->where('status', 'В ожидании')
                             ->get();

    return view('friends.index', compact('friends', 'friendRequests'));
}



public function search(Request $request)
{
    $searchTerm = $request->input('search');
    
    // Изменяем запрос для исключения текущего пользователя
    $users = User::where('id', '!=', Auth::id()) // Исключаем текущего пользователя
                 ->where(function ($query) use ($searchTerm) {
                     $query->where('login', 'like', '%'.$searchTerm.'%')
                           ->orWhere('email', 'like', '%'.$searchTerm.'%');
                 })
                 ->get();

    return view('friends.search', compact('users'));
}



public function add(Request $request, User $user)
{
    // Проверка на попытку отправить запрос самому себе
    if (Auth::id() === $user->id) {
        return redirect()->route('friends.index')->with('error', 'Вы не можете отправить запрос на дружбу самому себе.');
    }

    // Проверка на существование запроса на дружбу
    if (Friend::where('user_id', Auth::id())->where('friend_id', $user->id)->exists()) {
        return redirect()->route('friends.index')->with('error', 'Запрос на дружбу уже отправлен.');
    }

    // Проверка, является ли пользователь уже другом
    if (Friend::where(function($query) {
        $query->where('user_id', Auth::id())
              ->orWhere('friend_id', Auth::id());
    })->where(function($query) use ($user) {
        $query->where('user_id', $user->id)
              ->orWhere('friend_id', $user->id);
    })->where('status', 'Принято')->exists()) {
        return redirect()->route('friends.index')->with('already_friends', 'Пользователь уже в вашем списке друзей.');
    }

    // Создание нового запроса на дружбу
    $friend = new Friend();
    $friend->user_id = Auth::id();
    $friend->friend_id = $user->id;
    $friend->status = 'В ожидании'; // Устанавливаем статус как 'В ожидании'
    $friend->save();

    return redirect()->route('friends.index')->with('success', 'Запрос на дружбу отправлен.');
}





    public function accept(Request $request, User $user)
    {
        $friend = Friend::where('user_id', $user->id)
                        ->where('friend_id', Auth::id())
                        ->where('status', 'В ожидании') // Only accept pending requests
                        ->first();

        if ($friend) {
            $friend->status = 'Принято';
            $friend->save();

            return redirect()->route('friends.index')->with('success', 'Запрос на дружбу принят.');
        }

        return redirect()->route('friends.index')->with('error', 'Запрос на дружбу не найден.');
    }

    public function remove(Request $request, User $user)
    {
       // Находим запись о дружбе
        $friend = Friend::where(function($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->first();

        if ($friend) {
            // Удаляем запись о дружбе
            $friend->delete();
            return redirect()->route('friends.index')->with('success', 'Друг удален.');
        }

        return redirect()->route('friends.index')->with('error', 'Запись о дружбе не найдена.');
    }



    public function showChat(User $user)
{
    // Получаем чат между текущим пользователем и указанным пользователем
    $chat = Chat::where(function ($query) use ($user) {
        $query->where('user1_id', Auth::id())
              ->where('user2_id', $user->id);
    })->orWhere(function ($query) use ($user) {
        $query->where('user1_id', $user->id)
              ->where('user2_id', Auth::id());
    })->first();

    // Получаем сообщения из этого чата
    $messages = $chat ? $chat->messages()->get() : collect();

    // Обновляем поле read_at для всех сообщений, если они были отправлены другим пользователем
    if ($messages->isNotEmpty()) {
        foreach ($messages as $message) {
            if ($message->user_id !== Auth::id() && is_null($message->read_at)) {
                $message->read_at = now(); // Устанавливаем время прочтения
                $message->save(); // Сохраняем изменения
            }
        }
    }

    // Получаем информацию о пользователе (имя и фамилию)
    $firstName = $user->userInfo->first_name ?? '';
    $lastName = $user->userInfo->last_name ?? '';

    return view('friends.chat', compact('messages', 'user', 'firstName', 'lastName'));
}




public function sendMessage(Request $request, User $user)
{
    // Валидация сообщения
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    // Получаем или создаем чат между пользователями
    $chat = Chat::where(function ($query) use ($user) {
        $query->where('user1_id', Auth::id())
              ->where('user2_id', $user->id);
    })->orWhere(function ($query) use ($user) {
        $query->where('user1_id', $user->id)
              ->where('user2_id', Auth::id());
    })->first();

    // Если чат не найден, создаем новый
    if (!$chat) {
        $chat = Chat::create([
            'user1_id' => Auth::id(),
            'user2_id' => $user->id,
        ]);
    }

    // Создаем новое сообщение
    Message::create([
        'chat_id' => $chat->id,
        'user_id' => Auth::id(),
        'content' => $request->content,
        'read_at' => null,
    ]);

    return redirect()->route('friends.chat', $user)->with('success', 'Сообщение отправлено.');
}


}
