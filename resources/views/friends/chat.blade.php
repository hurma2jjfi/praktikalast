@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Чат с {{ '@' . $user->login }} </h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Статус пользователя (отображается один раз вверху) -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="flex items-center mb-4">
            <!-- Аватарка пользователя -->
            @if ($user->userInfo && $user->userInfo->avatar)
                <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-8 h-8 rounded-full mr-2">
            @else
                <img src="https://via.placeholder.com/32" alt="Нет аватара" class="w-8 h-8 rounded-full mr-2">
            @endif

            <!-- Имя пользователя, индикатор статуса и время последней активности -->
            <div class="flex items-center">
                <p class="font-bold">{{ $firstName }} {{ $lastName }}</p>
                <span class="ml-2">
                    @if ($user->isOnline())
                        <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span> <!-- Зеленый кружок -->
                        <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                    @else
                        <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span> <!-- Серый кружок -->
                        <span class="text-sm text-gray-500 ml-1">{{ $user->lastSeen() }}</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Список сообщений -->
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
                    <!-- Текст сообщения -->
                    <p>{{ $message->content }}</p>

                    <!-- Время отправки сообщения -->
                    <small class="text-gray-500">{{ $message->created_at->diffForHumans() }}</small>

                    <!-- Индикатор прочтения -->
                    @if ($message->user_id == Auth::id())
                        <div class="mt-1">
                            @if ($message->read_at)
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-check text-green-500"></i> 
                                    Прочитано: {{ $message->read_at->diffForHumans() }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-check text-gray-400"></i> 
                                    Не прочитано
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Форма отправки сообщения -->
    <form method="POST" action="{{ route('friends.sendMessage', $user) }}">
        @csrf
        <input type="text" name="content" placeholder="Введите сообщение" class="w-full p-2 border rounded" required>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded mt-2">Отправить</button>
    </form>
@endsection