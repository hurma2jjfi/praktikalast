@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Сообщения</h1>

    @if ($chats->isEmpty())
        <p>У вас пока нет сообщений.</p>
    @else
        @foreach($chats as $chat)
            <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center">
                @php
                    // Определяем собеседника
                    $otherUser = $chat->user1_id == auth()->id() ? $chat->user2 : $chat->user1;
                @endphp

                <!-- Аватарка собеседника -->
                @if ($otherUser->userInfo && $otherUser->userInfo->avatar)
                    <img src="{{ asset('storage/' . $otherUser->userInfo->avatar) }}" alt="Аватар" class="w-12 h-12 rounded-full mr-4">
                @else
                    <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                @endif

                <!-- Ссылка на чат -->
                <a href="{{ route('friends.chat', $otherUser) }}" class="text-blue-600">Диалог с {{ $otherUser->login }}</a>
            </div>
        @endforeach
    @endif
@endsection
