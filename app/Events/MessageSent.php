<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat; // Импортируем модель Chat

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;
    public $chat; // Добавляем свойство chat

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, User $user, Chat $chat)
    {
        $this->message = $message;
        $this->user = $user;
        $this->chat = $chat; // Инициализируем свойство chat
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // Используем PrivateChannel и передаем ID чата в качестве имени канала
        return new PrivateChannel('chat.' . $this->chat->id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'content' => $this->message->content,
                'created_at' => $this->message->created_at->toISOString(), // Форматируем время
                'user_id' => $this->message->user_id,
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->login, // Используем логин пользователя
                    'avatar_url' => $this->user->userInfo && $this->user->userInfo->avatar ? asset('storage/' . $this->user->userInfo->avatar) : null, // URL аватара
                ],
            ],
        ];
    }
}
