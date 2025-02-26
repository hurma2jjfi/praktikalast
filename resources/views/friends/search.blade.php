@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Поиск друзей</h1>
    <form method="GET" action="{{ route('friends.search') }}" class="mb-4">
        <div class="flex items-center gap-2">
            <input type="text" name="search" placeholder="Введите имя пользователя" class="w-full p-2 border rounded" required>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Искать</button>
        </div>
        
    </form>

    @if($users->isEmpty())
        <p>Пользователи не найдены.</p>
    @else
        @foreach($users as $user)
            <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center">
                <!-- Аватарка пользователя -->
                @if($user->userInfo && $user->userInfo->avatar)
                    <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-12 h-12 rounded-full mr-4">
                @else
                    <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                @endif

                <!-- Информация о пользователе и статус активности -->
                <div>
                    <!-- Ссылка на профиль пользователя -->
                    <a href="{{ route('profile.another', $user) }}" class="hover:underline">
                        <p>{{ $user->login }}</p>
                    </a>
                    <div class="flex items-center">
                        @if ($user->isOnline())
                            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span> <!-- Зеленый кружок -->
                            <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                        @else
                            <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span> <!-- Серый кружок -->
                            <span class="text-sm text-gray-500 ml-1">{{ $user->lastSeen() }}</span>
                        @endif
                    </div>
                </div>

                <!-- Кнопка "Добавить в друзья" -->
                <div class="ml-auto">
                    <form method="POST" action="{{ route('friends.add', $user) }}">
                        @csrf
                        <button type="submit" class="text-blue-600">Добавить в друзья</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
@endsection