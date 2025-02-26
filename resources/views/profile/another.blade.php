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
        <div class="flex items-center">
            @if ($friends->count() > 0)
            <div class="flex items-center mt-2">
                @foreach ($friends as $friend)
                    <div class="relative w-12 h-12 rounded-full mr-1 gradient-border">
                        <a href="{{ route('profile.another', $friend) }}" class="hover:underline" title="{{ $friend->userInfo->first_name }} {{ $friend->userInfo->last_name }}">
                            @if ($friend->userInfo && $friend->userInfo->avatar)
                                <img src="{{ asset('storage/' . $friend->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                    <p class="text-gray-500 text-xs">Аватар</p>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
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
    
            @if($post->image)
                <img src="{{ asset($post->image) }}" alt="Пост">
            @endif
    
            @if($post->video)
                <div class="video-container relative">
                    <video id="myVideo" width="100%" controls>
                        <source src="{{ asset($post->video) }}" type="video/mp4">
                        Ваш браузер не поддерживает тег video.
                    </video>
                    <button id="playButton" class="play-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </button>
                </div>
            @endif
    
            <p>{{ $post->content }}</p>
            <p style="font-style: italic">{{'Категория: ' . $post->category->name }}</p>
            <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
    
            <!-- Комментарии к посту -->
            <div class="mt-4">
                <h3 class="font-bold mb-2">Комментарии:</h3>
                @foreach ($post->comments as $comment)
                    <div class="mb-2 flex items-start">
                        <!-- Аватарка пользователя -->
                        <div class="relative w-14 h-14 rounded-full mr-3 gradient-border">
                            @if ($comment->user->userInfo && $comment->user->userInfo->avatar)
                                <img src="{{ asset('storage/' . $comment->user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                    <p class="text-gray-500 text-xs">Аватар</p>
                                </div>
                            @endif
                        </div>
    
                        <!-- Текст комментария -->
                        <div>
                            <p><strong>{{ $comment->user->login }}:</strong> {{ $comment->content }}</p>
                            <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
    
            <!-- Форма для добавления комментария -->
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="content" rows="2" class="w-full p-2 border rounded" placeholder="Оставьте комментарий..." required></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Отправить</button>
            </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('myVideo');
        const playButton = document.getElementById('playButton');

        playButton.addEventListener('click', function() {
            if (video.paused) {
                video.play();
                playButton.style.display = 'none'; // Скрыть кнопку при воспроизведении
            } else {
                video.pause();
                playButton.style.display = 'block'; // Показать кнопку при паузе
            }
        });

        // Скрыть кнопку, когда видео заканчивается
        video.addEventListener('ended', function() {
            playButton.style.display = 'block'; // Показать кнопку после окончания
        });
    });
</script>