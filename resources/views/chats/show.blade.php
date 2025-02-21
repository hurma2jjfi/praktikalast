@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Чат с {{ $chat->user1_id == auth()->id() ? $chat->user2->login : $chat->user1->login }}</h1>
    @foreach($messages as $message)
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <p><strong>{{ $message->user->login }}:</strong> {{ $message->content }}</p>
            <small>{{ $message->created_at->diffForHumans() }}</small>
        </div>
    @endforeach

    <form method="POST" action="{{ route('chats.send', $chat) }}" class="mb-4">
        @csrf
        <textarea name="content" placeholder="Введите сообщение" class="w-full p-2 border rounded" required></textarea>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded mt-2">Отправить</button>
    </form>
@endsection