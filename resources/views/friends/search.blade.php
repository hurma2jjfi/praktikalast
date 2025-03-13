@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Поиск друзей</h1>
    <form method="GET" action="{{ route('friends.search') }}" class="mb-6">
        <div class="flex items-center gap-2">
            <input type="text" name="search" placeholder="Введите имя пользователя" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="search__btn"><img src="{{ asset('assets/Group 240 (1).svg') }}" alt=""></button>
        </div>
    </form>

    @if($users->isEmpty())
        <p class="text-gray-500">Пользователи не найдены.</p>
    @else
        <div class="bg-white rounded-lg shadow-sm">


            @foreach($users as $user)
            @if(!$user->is_admin)
            <div class="p-4 flex items-center border-b last:border-b-0 hover:bg-gray-50 transition-colors">
                <!-- Аватарка пользователя -->
                <div class="relative w-10 h-10 rounded-full mr-4 gradient-border">
                    @if($user->userInfo && $user->userInfo->avatar)
                        <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                    @else
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-sm">?</span>
                        </div>
                    @endif
                </div>

                <!-- Информация о пользователе -->
                <div class="flex-1">
                    <a href="{{ route('profile.another', $user) }}" class="hover:underline">
                        <p class="font-medium">{{ $user->firstName }} {{ $user->lastName }}</p>
                    </a>
                    <div class="flex items-center mt-1">
                        @if ($user->isOnline())
                            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
                            <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                        @else
                            <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span>
                            <span class="text-sm text-gray-500 ml-1">{{ $user->lastSeen() }}</span>
                        @endif
                    </div>
                </div>

                <!-- Кнопка "Добавить в друзья" -->
                <form method="POST" action="{{ route('friends.add', $user) }}">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:text-blue-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </button>
                </form>
            </div>
            @endif      
            @endforeach



        </div>
    @endif

    <!-- Уведомления об ошибках и успехе -->
    @if (session('error'))
        <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
@endsection

<style>
    .gradient-border {
        padding: 2px;
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-radius: 50%;
    }

    .gradient-border img {
        border: 2px solid white;
        border-radius: 50%;
    }

    .search__btn {
        width: 70px;
        height: 38px;
        border-radius: 7px;
        background-color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search__btn:hover {
        background-color: #000;
        transition: 0.9s;
    }
</style>