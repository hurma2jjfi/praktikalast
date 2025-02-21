<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
{
    $user = Auth::user();
    // Получаем все чаты, в которых участвует текущий пользователь
    $chats = Chat::where('user1_id', $user->id)
                 ->orWhere('user2_id', $user->id)
                 ->with(['user1', 'user2']) // Загружаем пользователей для каждого чата
                 ->get();

    return view('chats.index', compact('chats'));
}


public function show(User $user)
{
    // Проверяем, есть ли чат между текущим пользователем и указанным пользователем
    $chat = Chat::where(function ($query) use ($user) {
        $query->where('user1_id', Auth::id())
              ->where('user2_id', $user->id);
    })->orWhere(function ($query) use ($user) {
        $query->where('user1_id', $user->id)
              ->where('user2_id', Auth::id());
    })->first();

    // Если чат найден, перенаправляем на существующий маршрут
    if ($chat) {
        return redirect()->route('chats.show', $chat);
    }

    // Если чата нет, создаем новый
    $chat = Chat::create([
        'user1_id' => Auth::id(),
        'user2_id' => $user->id,
    ]);

    return redirect()->route('chats.show', $chat);
}


public function showChat(Chat $chat)
{
    // Проверяем, что текущий пользователь является участником чата
    if ($chat->user1_id !== Auth::id() && $chat->user2_id !== Auth::id()) {
        abort(403, 'Вы не имеете доступа к этому чату.');
    }

    // Получаем сообщения из чата
    $messages = Message::where('chat_id', $chat->id)
                       ->orderBy('created_at', 'asc')
                       ->with('user')
                       ->get();

    // Определяем собеседника
    $otherUser = $chat->user1_id === Auth::id() ? $chat->user2 : $chat->user1;

    return view('chats.show', compact('chat', 'messages', 'otherUser'));
}


    public function sendMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->user_id = Auth::id();
        $message->content = $request->content;
        $message->save();

        return redirect()->route('chats.show', $chat->id);
    }
}
