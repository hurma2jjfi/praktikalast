@extends('layouts.app')

@section('content')
<div x-data="{ activeTab: 'friends' }" class="py-16 px-6">
    <h1 class="text-2xl font-bold mb-4">Друзья</h1>

    <!-- Вкладки -->
    <div class="flex flex-col sm:flex-row sm:space-x-4 mb-6 border-b border-gray-200">
        <button
            @click="activeTab = 'friends'"
            :class="{ 'border-b-2 border-black': activeTab === 'friends' }"
            class="px-4 py-2 text-gray-700 hover:text-black focus:outline-none w-full sm:w-auto text-left sm:text-center"
        >
            Друзья
        </button>
        <button
            @click="activeTab = 'requests'"
            :class="{ 'border-b-2 border-black': activeTab === 'requests' }"
            class="px-4 py-2 text-gray-700 hover:text-black focus:outline-none w-full sm:w-auto text-left sm:text-center relative"
        >
            Запросы в друзья
            @if ($friendRequestsCount > 0)
                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-2 py-1 transform translate-x-1/2 -translate-y-1/2">
                    {{ $friendRequestsCount }}
                </span>
            @endif
        </button>
        <button
            @click="activeTab = 'search'"
            :class="{ 'border-b-2 border-black': activeTab === 'search' }"
            class="px-4 py-2 text-gray-700 hover:text-black focus:outline-none w-full sm:w-auto text-left sm:text-center"
        >
            Поиск друзей
        </button>
    </div>

    <!-- Секция "Друзья" -->
    <div x-show="activeTab === 'friends'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
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

        @if (count($friends) > 0)
            @foreach($friends as $friend)
                <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex flex-col sm:flex-row items-center justify-between transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-4 sm:mb-0">
                        @if ($friend->userInfo && $friend->userInfo->avatar)
                            <img src="{{ asset('storage/' . $friend->userInfo->avatar) }}" alt="Аватар" class="w-14 h-14 rounded-full mr-4">
                        @else
                            <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                        @endif
                        <div>
                            <a href="{{ route('profile.another', $friend) }}" class="hover:underline font-medium">
                                {{ $friend->userInfo->first_name }} {{ $friend->userInfo->last_name }}
                            </a>
                            <p class="text-sm text-gray-500">Статус: У вас в друзьях</p>
                            <div class="flex items-center">
                                @if ($friend->isOnline())
                                    <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
                                    <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                                @else
                                    <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span>
                                    <span class="text-sm text-gray-500 ml-1">{{ $friend->lastSeen() }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <form method="POST" action="{{ route('friends.remove', $friend) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition-colors duration-300 w-full sm:w-auto">Удалить из друзей</button>
                        </form>
                        <a href="{{ route('friends.chat', $friend) }}" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors duration-300 w-full sm:w-auto text-center">Написать сообщение</a>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">У вас пока нет друзей.</p>
        @endif
    </div>

    <!-- Секция "Запросы в друзья" -->
    <div x-show="activeTab === 'requests'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        @if(count($friendRequests) > 0)
            @foreach($friendRequests as $request)
                <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex flex-col sm:flex-row items-center justify-between transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-4 sm:mb-0">
                        @if ($request->user->userInfo && $request->user->userInfo->avatar)
                            <img src="{{ asset('storage/' . $request->user->userInfo->avatar) }}" alt="Аватар" class="w-12 h-12 rounded-full mr-4">
                        @else
                            <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
                        @endif
                        <div>
                            <p class="font-medium">{{ $request->user->login }}</p>
                            <p class="text-sm text-gray-500">{{ $request->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <form method="POST" action="{{ route('friends.accept', $request->user) }}">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 transition-colors duration-300 w-full sm:w-auto">Принять</button>
                        </form>
                        <form method="POST" action="{{ route('friends.remove', $request->user) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition-colors duration-300 w-full sm:w-auto">Отклонить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">У вас нет входящих запросов в друзья.</p>
        @endif
    </div>

    <!-- Секция "Поиск друзей" -->
    <div x-show="activeTab === 'search'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <a href="{{ route('friends.search') }}" class="bg-blue-600 text-white p-2 rounded mb-4 inline-block hover:bg-blue-700 transition-colors duration-300 w-full sm:w-auto text-center">Поиск друзей</a>
    </div>
</div>
@endsection