@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Чат с {{ $user->login }}</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        @foreach($messages as $message)
            <div class="flex items-start mb-2 {{ $message->user_id == Auth::id() ? 'flex-row-reverse text-right' : 'text-left' }}">
                <!-- Аватарка пользователя -->
                @if ($message->user->userInfo && $message->user->userInfo->avatar)
                    <img src="{{ asset('storage/' . $message->user->userInfo->avatar) }}" alt="Аватар" class="w-8 h-8 rounded-full mr-2 ml-2">
                @else
                    <img src="https://via.placeholder.com/32" alt="Нет аватара" class="w-8 h-8 rounded-full mr-2 ml-2">
                @endif

                <!-- Сообщение и информация о пользователе -->
                <div>
                    <p><strong>{{ $message->user->login }}:</strong> {{ $message->content }}</p>
                    <small class="text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('friends.sendMessage', $user) }}">
        @csrf
        <input type="text" name="content" placeholder="Введите сообщение" class="w-full p-2 border rounded" required>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded mt-2">Отправить</button>
    </form>
@endsection
