@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Сообщения</h1>

    @if ($chats->isEmpty())
        <p>У вас пока нет сообщений.</p>
    @else
        @foreach($chats as $chat)
            @php
                // Определяем собеседника
                $otherUser = $chat->user1_id == auth()->id() ? $chat->user2 : $chat->user1;
            @endphp

            <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center">
                <!-- Аватарка собеседника -->
                @if ($otherUser->userInfo && $otherUser->userInfo->avatar)
                    <img src="{{ asset('storage/' . $otherUser->userInfo->avatar) }}" alt="Аватар" class="w-14 h-14 rounded-full mr-4">
                @else
                    <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                @endif

                <!-- Информация о собеседнике и статус активности -->
                <div class="flex-1">
                    <a href="{{ route('friends.chat', $otherUser) }}" class="text-blue-600 text-decoration: underline">Диалог с {{ $otherUser->login }}</a>
                    <div class="flex items-center">
                        @if ($otherUser->isOnline())
                            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span> <!-- Зеленый кружок -->
                            <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                        @else
                            <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span> <!-- Серый кружок -->
                            <span class="text-sm text-gray-500 ml-1">{{ $otherUser->lastSeen() }}</span>
                        @endif
                    </div>
                </div>

                <!-- Счетчик непрочитанных сообщений -->
                @if ($chat->unread_count > 0)
                    <span class="count__messages">
                        {{ $chat->unread_count }}
                    </span>
                @endif
            </div>
        @endforeach
    @endif

    <style>
        .count__messages {
        display: inline-block;
        width: 30px; /* Уменьшен размер для компактности */
        height: 30px; /* Уменьшен размер для компактности */
        border-radius: 50%;
        background-color: blueviolet;
        color: #fff;
        text-align: center;
        line-height: 27px; /* Добавлено выравнивание текста по вертикали */
    }
    </style>
@endsection