@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Профиль:</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="flex items-center mb-4">
            <!-- Аватарка пользователя с градиентной границей -->
            <div class="relative w-32 h-32 rounded-full mr-4 gradient-border">
                @if (auth()->user()->userInfo && auth()->user()->userInfo->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                @else
                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">Аватар не установлен</p>
                    </div>
                @endif
            </div>

            <!-- Информация о пользователе и статус активности -->
            <div>
                <p><strong>Имя</strong> — {{ auth()->user()->userInfo->first_name }}</p>
                <p><strong>Фамилия</strong> — {{ auth()->user()->userInfo->last_name }}</p>
                <p><strong>Логин</strong> — {{ auth()->user()->login }}</p>
                <p><strong>Email</strong> — {{ auth()->user()->email }}</p>
                <p><strong>Друзей</strong> — {{ $friendCount }}</p>

                <!-- Статус активности -->
                <div class="flex items-center">
                    @if (auth()->user()->isOnline())
                        <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span> <!-- Зеленый кружок -->
                        <span class="text-sm text-gray-500 ml-1">Онлайн</span>
                    @else
                        <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span> <!-- Серый кружок -->
                        <span class="text-sm text-gray-500 ml-1">{{ auth()->user()->lastSeen() }}</span>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="text-blue-600">Редактировать профиль</a><br><br>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white p-2 rounded mb-4 inline-block">Создать пост</a>

        <form action="{{ route('profile.destroy') }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white p-2 rounded"
                onclick="return confirm('Вы уверены, что хотите удалить свой аккаунт? Это действие необратимо.')">Удалить аккаунт</button>
        </form>
    </div>

    {{-- ///////////////////////////////////////////////////Публикации --}}
    <h1 class="text-2xl font-bold mb-4">Мои посты:</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        @if ($posts->isEmpty())
            <p>У вас пока нет постов.</p>
        @else
            @foreach ($posts as $post)
                <div class="mb-4">
                    <h2 class="font-bold">{{ $post->title }}</h2>
                    <img src="{{ asset($post->image) }}" alt="Пост">
                    <p>{{ $post->content }}</p>
                    <p style="font-style: italic">{{'Категория: ' . $post->category->name }}</p>
                    <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
                    <div class="flex items-center">
                        <a href="{{ route('posts.edit', $post) }}"
                            class="bg-blue-600 text-white p-2 rounded mr-2">Редактировать</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded"
                                onclick="return confirm('Вы уверены, что хотите удалить этот пост?')">Удалить</button>
                        </form>
                    </div>
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