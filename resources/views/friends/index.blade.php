@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Друзья</h1>
    <a href="{{ route('friends.search') }}" class="bg-blue-600 text-white p-2 rounded mb-4 inline-block">Поиск друзей</a>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('already_friends'))
        <div class="bg-yellow-500 text-white p-2 rounded mb-4">
            {{ session('already_friends') }}
        </div>
    @endif

    <h2 class="text-xl font-bold mb-2">Список друзей</h2>
    @if (count($friends) > 0)
        @foreach($friends as $friend)
            <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Аватарка друга -->
                    @if ($friend->userInfo && $friend->userInfo->avatar)
                        <img src="{{ asset('storage/' . $friend->userInfo->avatar) }}" alt="Аватар" class="w-12 h-12 rounded-full mr-4">
                    @else
                        <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                    @endif

                    <!-- Информация о друге -->
                    <div>
                        <p>{{ $friend->userInfo->first_name }} {{ $friend->userInfo->last_name }}</p>
                        <p>Статус: Принято</p>
                        <!-- Время последней активности -->
                        <div class="flex items-center">
                            @if ($friend->isOnline())
                                <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span> <!-- Зеленый кружок -->
                                <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                            @else
                                <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span> <!-- Серый кружок -->
                                <span class="text-sm text-gray-500 ml-1">{{ $friend->lastSeen() }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('friends.chat', $friend) }}" class="bg-blue-600 text-white p-2 rounded">Написать сообщение</a>
                </div>
            </div>
        @endforeach
    @else
        <p>У вас пока нет друзей.</p>
    @endif

    <h2 class="text-xl font-bold mb-2">Входящие запросы в друзья</h2>
    @if(count($friendRequests) > 0)
        @foreach($friendRequests as $request)
            <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Аватарка отправителя запроса -->
                    @if ($request->user->userInfo && $request->user->userInfo->avatar)
                        <img src="{{ asset('storage/' . $request->user->userInfo->avatar) }}" alt="Аватар" class="w-12 h-12 rounded-full mr-4">
                    @else
                        <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                    @endif

                    <!-- Информация о пользователе -->
                    <div>
                        <p>{{ $request->user->login }}</p>
                        <p>{{ $request->user->email }}</p>
                    </div>
                </div>

                <!-- Кнопки для принятия или отклонения запроса -->
                <div>
                    <form method="POST" action="{{ route('friends.accept', $request->user) }}">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white p-2 rounded">Принять</button>
                    </form>
                    <form method="POST" action="{{ route('friends.remove', $request->user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white p-2 rounded">Отклонить</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>У вас нет входящих запросов в друзья.</p>
    @endif
@endsection