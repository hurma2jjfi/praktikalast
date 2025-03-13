@extends('layouts.app')

@section('content')
<div x-data="{ activeTab: 'friends' }" class="py-16 px-6">
    <h1 class="text-2xl font-bold mb-4">Друзья</h1>

    <!-- Вкладки -->
    <div class="flex flex-col sm:flex-row sm:space-x-4 mb-6 border-b border-gray-200">
        <button
            @click="activeTab = 'friends'"
            :class="{ 'border-b-2 border-black': activeTab === 'friends' }"
            class="px-4 py-2 text-gray-700 hover:text-blue-500 focus:outline-none w-full sm:w-auto text-left sm:text-center"
        >
            Друзья
        </button>
        <button
            @click="activeTab = 'requests'"
            :class="{ 'border-b-2 border-black': activeTab === 'requests' }"
            class="px-4 py-2 text-gray-700 hover:text-blue-500 focus:outline-none w-full sm:w-auto text-left sm:text-center relative"
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
            class="px-4 py-2 text-gray-700 hover:text-blue-500 focus:outline-none w-full sm:w-auto text-left sm:text-center"
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
            <div class="bg-white rounded-lg shadow-sm">
                @foreach($friends as $friend)
                    <div class="p-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <!-- Аватарка с индикатором онлайн-статуса -->
                                <div class="relative w-10 h-10 rounded-full mr-3">
                                    @if ($friend->userInfo && $friend->userInfo->avatar)
                                        <img src="{{ asset('storage/' . $friend->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                            <p class="text-gray-500 text-xs">Аватар</p>
                                        </div>
                                    @endif
                                    <!-- Индикатор онлайн-статуса -->
                                    @if ($friend->isOnline())
                                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"></span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('profile.another', $friend) }}" class="hover:underline font-medium">
                                        {{ $friend->userInfo->first_name }} {{ $friend->userInfo->last_name }}
                                    </a>
                                    <p class="text-sm text-gray-500">
                                        @if ($friend->isOnline())
                                            <span class="text-green-500">Онлайн</span>
                                        @else
                                            {{ $friend->lastSeen() }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Кнопка "Написать сообщение" -->
                                <div class="flex__btns">
                                <a id="padding" href="{{ route('friends.chat', $friend) }}" class="button">
                                    Написать
                                </a>
                                <!-- Кнопка "Удалить из друзья" -->
                                <form method="POST" action="{{ route('friends.remove', $friend) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button--remove">
                                        Удалить
                                    </button>
                                </form></div>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">У вас пока нет друзей.</p>
        @endif
    </div>

    <!-- Секция "Запросы в друзья" -->
    <div x-show="activeTab === 'requests'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        @if(count($friendRequests) > 0)
            <div class="bg-white rounded-lg shadow-sm">
                @foreach($friendRequests as $request)
                    <div class="p-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <!-- Аватарка с индикатором онлайн-статуса -->
                                <div class="relative w-10 h-10 rounded-full mr-3">
                                    @if ($request->user->userInfo && $request->user->userInfo->avatar)
                                        <img src="{{ asset('storage/' . $request->user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                            <p class="text-gray-500 text-xs">Аватар</p>
                                        </div>
                                    @endif
                                    <!-- Индикатор онлайн-статуса -->
                                    @if ($request->user->isOnline())
                                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"></span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium">{{ $request->user->login }}</p>
                                    <p class="text-sm text-gray-500">{{ $request->user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Кнопка "Принять" -->
                                <form method="POST" action="{{ route('friends.accept', $request->user) }}">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors duration-300">
                                        Принять
                                    </button>
                                </form>
                                <!-- Кнопка "Отклонить" -->
                                <form method="POST" action="{{ route('friends.remove', $request->user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-300">
                                        Отклонить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">У вас нет входящих запросов в друзья.</p>
        @endif
    </div>

    <!-- Секция "Поиск друзей" -->
    <div x-show="activeTab === 'search'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <a href="{{ route('friends.search') }}" class="bg-blue-500 text-white p-2 rounded mb-4 inline-block hover:bg-blue-600 transition-colors duration-300 w-full sm:w-auto text-center">Поиск друзей</a>
    </div>
</div>
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

    .online-indicator {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background-color: #4CAF50; /* Зеленый цвет */
        border-radius: 50%;
        border: 2px solid white; /* Белая обводка */
    }

    @media (max-width: 700px) {
        .online-indicator {
            width: 8px;
            height: 8px;
            border-width: 1px;
        }
    }

    .button {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    background-color: #2563EB;
    color: #ffffff;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
    
}

.button:hover {
    background-color: #000000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Добавляет тень при наведении */
}

.button--remove {
    background-color: #f0f0f0;
    color: #333;
}

.button--remove:hover {
    background-color: #e5e5e5;
}

/* Если хотите сделать кнопку "Удалить" черной */
.button--remove {
    background-color: #d40a0a;
    color: #fff;
}

.button--remove:hover {
    background-color: #db0707;
}

.flex__btns {
    display: flex;
    flex-direction: row;
    gap: 10px;
}

#padding {
    height: 33px;
}

</style>