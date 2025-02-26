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


        <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800">Редактировать профиль</a><br><br>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white p-2 rounded mb-4 inline-block hover:bg-blue-700">Создать пост</a>

        <form action="{{ route('profile.destroy') }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600"
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
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h2 class="font-bold text-xl mb-2">{{ $post->title }}</h2>
                    @if ($post->image)
                        <img src="{{ asset($post->image) }}" alt="Пост" class="w-full h-auto rounded-lg mb-4">
                    @endif
                    <p class="text-gray-700 mb-4">
                        @php
                            $content = $post->content;
                            $content = preg_replace('/(https?:\/\/[^\s]+)/', '<a id="links__prew" href="$1" target="_blank">$1</a>', $content);
                        @endphp
                        {!! $content !!}
                    </p>

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
                    
                    <p class="text-gray-500 mb-4">{{'Категория: ' . $post->category->name }}</p>
                    <small class="text-gray-400">{{ $post->created_at->diffForHumans() }}</small>
                    <div class="flex items-center gap-2 mt-4">
                        <a href="{{ route('posts.edit', $post) }}"
                            class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Редактировать</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600"
                                onclick="return confirm('Вы уверены, что хотите удалить этот пост?')">Удалить</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-bold mb-2">Комментарии:</h3>
                        @if ($post->comments->isEmpty())
                            <p class="text-gray-500">К этому посту пока нет комментариев.</p>
                        @else
                            @foreach ($post->comments as $comment)
                                <div class="mb-4 pb-4 border-b border-gray-200">
                                    <div class="flex items-start">
                                        <!-- Аватарка пользователя -->
                                        <div class="relative w-10 h-10 rounded-full mr-3 gradient-border">
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
                                            <!-- Ссылка на профиль пользователя -->
                                            <a href="{{ route('profile.another', $comment->user) }}" class="hover:underline">
                                                <p><strong>{{ $comment->user->login }}:</strong> {{ $comment->content }}</p>
                                            </a>
                                            <small class="text-gray-400">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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

    a {
        text-decoration: none;
    }
    #links__prew:hover {
        text-decoration: underline;
    }

    .bg-blue-600 {
        transition: background-color 0.3s ease;
    }

    .bg-blue-600:hover {
        background-color: #1e40af;
    }

    .bg-red-500 {
        transition: background-color 0.3s ease;
    }

    .bg-red-500:hover {
        background-color: #dc2626;
    }

    .flex.gap-2 {
        gap: 0.5rem; /* Отступ между кнопками */
    }

    @media (max-width: 700px) {
    .flex.items-center {
        flex-direction: column;
        align-items: flex-start;
    }

    .relative.w-32.h-32 {
        width: 100px;
        height: 100px;
    }

    .text-2xl {
        font-size: 1.5rem;
    }

    .bg-white.p-4.rounded-lg.shadow-md {
        padding: 1rem;
    }

    .flex.gap-2 {
        flex-direction: column;
    }

    .bg-blue-600, .bg-red-500 {
        width: 100%;
        text-align: center;
    }

    .mb-6.pb-6.border-b.border-gray-200 {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .font-bold.text-xl {
        font-size: 1.25rem;
    }

    .text-gray-700.mb-4 {
        font-size: 0.9rem;
    }

    .text-gray-500.mb-4 {
        font-size: 0.8rem;
    }

    .text-gray-400 {
        font-size: 0.75rem;
    }

    .gradient-border {
        padding: 2px;
    }

    .gradient-border img {
        border: 2px solid white;
    }
}

.video-container {
    position: relative;
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: transparent;
    border: none;
    cursor: pointer;
    z-index: 10; /* Убедитесь, что кнопка выше видео */
}

.play-button svg {
    width: 48px; /* Размер иконки */
    height: 48px;
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