@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Профиль</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <p><strong>Логин:</strong> {{ auth()->user()->login }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        @if (auth()->user()->userInfo && auth()->user()->userInfo->avatar)
            <img src="{{ asset('storage/' . auth()->user()->userInfo->avatar) }}" alt="Аватар"
                class="w-32 h-32 rounded-full mb-2">
        @else
            <p>Аватар не установлен.</p>
        @endif
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
    <h1 class="text-2xl font-bold mb-4">Мои посты</h1>
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
