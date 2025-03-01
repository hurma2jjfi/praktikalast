@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Сообщения</h1>

    @if ($chats->isEmpty())
        <p class="text-gray-500">У вас пока нет сообщений.</p>
    @else
        <div class="bg-white rounded-lg shadow-sm">
            @foreach($chats as $chat)
                @php
                    // Определяем собеседника
                    $otherUser = $chat->user1_id == auth()->id() ? $chat->user2 : $chat->user1;
                @endphp

                <a href="{{ route('friends.chat', $otherUser) }}" class="block p-4 border-b last:border-b-0 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <!-- Аватарка собеседника -->
                        <div class="relative w-12 h-12 rounded-full mr-4 gradient-border">
                            @if ($otherUser->userInfo && $otherUser->userInfo->avatar)
                                <img src="{{ asset('storage/' . $otherUser->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500 text-sm">?</span>
                                </div>
                            @endif
                        </div>

                        <!-- Информация о собеседнике и статус активности -->
                        <div class="flex-1">
                            <p class="font-medium">{{ $otherUser->login }}</p>
                            <div class="flex items-center mt-1">
                                @if ($otherUser->isOnline())
                                    <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
                                    <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                                @else
                                    <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span>
                                    <span class="text-sm text-gray-500 ml-1">{{ $otherUser->lastSeen() }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Счетчик непрочитанных сообщений -->
                        @if ($chat->unread_count > 0)
                            <div class="bg-red-600 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">
                                {{ $chat->unread_count }}
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection

<style>
    .gradient-border {
        padding: 2px; /* Толщина границы */
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-radius: 50%;
    }

    .gradient-border img {
        border: 2px solid white; /* Внутренняя граница, чтобы отделить аватар от градиента */
        border-radius: 50%;
    }

    /* Стили для разделительных линий */
    .border-b {
        border-bottom: 1px solid #e5e7eb; /* Легкая серая линия */
    }

    /* Hover-эффект для диалогов */
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb; /* Легкий серый фон при наведении */
    }
</style>