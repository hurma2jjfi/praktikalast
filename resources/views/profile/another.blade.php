@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Профиль пользователя: {{ $user->login }}</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="flex items-center mb-4">
            <!-- Аватарка пользователя с градиентной границей -->
            <div class="relative w-32 h-32 rounded-full mr-4 gradient-border">
                @if ($user->userInfo && $user->userInfo->avatar)
                    <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                @else
                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">Аватар не установлен</p>
                    </div>
                @endif
            </div>

            <!-- Информация о пользователе и статус активности -->
            <div>
                <p><strong>Имя</strong> — {{ $user->userInfo->first_name }}</p>
                <p><strong>Фамилия</strong> — {{ $user->userInfo->last_name }}</p>
                <p><strong>Логин</strong> — {{ $user->login }}</p>
                <p><strong>Email</strong> — {{ $user->email }}</p>
                <p><strong>Друзей</strong> — {{ $friendCount }}</p>

                <!-- Статус активности -->
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
        </div>
    </div>

    {{-- ///////////////////////////////////////////////////Публикации --}}
    <h1 class="text-2xl font-bold mb-4">Публикации пользователя:</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        @if ($posts->isEmpty())
            <p>У пользователя пока нет постов.</p>
        @else
            @foreach ($posts as $post)
                <div class="mb-4">
                    <h2 class="font-bold">{{ $post->title }}</h2>
                    <img src="{{ asset($post->image) }}" alt="Пост">
                    <p>{{ $post->content }}</p>
                    <p style="font-style: italic">{{'Категория: ' . $post->category->name }}</p>
                    <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @endif
    </div>
@endsection

<style>
    .gradient-border {
        padding: 4px; /* Толщина границы */
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-radius: 50%;
    }

    .gradient-border img {
        border: 4px solid white; /* Внутренняя граница, чтобы отделить аватар от градиента */
        border-radius: 50%;
    }
</style>
