@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Профиль:</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="flex items-center mb-4">
            <!-- Аватарка пользователя с градиентной границей -->
            <div class="relative w-32 h-32 rounded-full mr-4 gradient-border">
                @if ($user->userInfo && $user->userInfo->avatar)
                    <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                    <a style="text-decoration: underline; color: #2563EB; padding-left: 10px;" href="{{ route('profile.edit') }}">Редактировать</a>
                @else
                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">Аватар не установлен</p>
                    </div>
                @endif
                {{-- Кружок статуса активности --}}
                @if ($user->isOnline())
                    <span class="absolute bottom-2 right-4 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
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
                        <span class="text-sm text-gray-500 ml-1 mt-1">Онлайн</span>
                    @else
                        <span class="w-2 h-2 bg-gray-400 rounded-full inline-block"></span> <!-- Серый кружок -->
                        <span class="text-sm text-gray-500 ml-1">{{ $user->lastSeen() }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center">
            <div class="wrapper__btn mr-4">
                <a style="color: #fff;" href="{{ route('posts.create') }}"><button class="create__a__post"><img src={{ asset('./assets/plusdva.svg') }} alt="">Создать пост</button></a></div>
                <form action="{{ route('profile.destroy') }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 flex items-center"
                        onclick="return confirm('Вы уверены, что хотите удалить свой аккаунт? Это действие необратимо.')">
                        <img src={{ asset('./assets/deleteaccount.svg') }} alt="Удалить" class="w-5 h-5 mr-2">
                        Удалить аккаунт
                    </button>
                </form>                
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
    <h1 class="text-2xl font-bold mb-4">Мои публикации:</h1>
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        @if ($posts->isEmpty())
            <p>У вас пока нет постов.</p>
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
        
            <!-- Форма для лайков -->
            <div class="mt-4">
                <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form">
                    @csrf
                    <button type="submit" class="flex items-center text-red-500 hover:text-red-500">
                        <svg class="w-6 h-6 like-icon" fill="{{ $post->isLikedBy(Auth::user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="ml-1 likes-count">{{ $post->likesCount() }}</span>
                    </button>
                </form>
                <canvas class="confetti-canvas" style="position: fixed; top: 0; left: 0; pointer-events: none; z-index: 9999;"></canvas>
            </div>
        
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
    .confetti-canvas {
        width: 100%;
        height: 100vh;
    }

    .gradient-border {
        padding: 4px; /* Толщина границы */
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-radius: 50%;
    }

    .gradient-border img {
        border: 4px solid white; /* Внутренняя граница, чтобы отделить аватар от градиента */
        border-radius: 50%;
    }

    .create__a__post {
  width: 147px;
  height: 43px;
  padding: 0 10px; /* Горизонтальный отступ */
  box-sizing: border-box; /* Чтобы ширина включала padding и border */
  font-size: 14px; /* Размер шрифта */
  text-align: center; /* Выравнивание текста */
  background-color: #2563EB;
  color: #fff;
  border-radius: 7px;
  display: flex; /* Используем flexbox для выравнивания */
  justify-content: center; /* Горизонтальное выравнивание */
  align-items: center; /* Вертикальное выравнивание */
  gap: 10px; /* Расстояние между элементами */
  flex-wrap: nowrap; /* Элементы не переносятся на новую строку */
  overflow: hidden; /* Скрытие содержимого, выходящего за пределы */
}

.create__a__post img {
  width: 25px; /* Уменьшение размера изображения */
  height: 25px; /* Уменьшение размера изображения */
}

.create__a__post a {
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden; 
}




</style>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('myVideo');
    const playButton = document.getElementById('playButton');

    playButton.addEventListener('click', function() {
        if (video.paused) {
            video.play();
            playButton.style.display = 'none';
        } else {
            video.pause();
            playButton.style.display = 'block';
        }
    });

    video.addEventListener('ended', function() {
        playButton.style.display = 'block';
    });

    // Обработка лайков через AJAX и анимации для каждого поста
    
});

document.addEventListener('DOMContentLoaded', function() {
    // Обработка лайков через AJAX
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Отменяем стандартное поведение формы

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}) // Пустое тело запроса
            })
            .then(response => response.json())
            .then(data => {
                const likeIcon = form.querySelector('.like-icon');
                const likesCount = form.querySelector('.likes-count');

                // Обновляем иконку лайка
                if (data.liked) {
                    likeIcon.setAttribute('fill', 'currentColor'); // Заполненная иконка

                    // Получаем координаты кнопки лайка
                    const buttonRect = form.querySelector('button').getBoundingClientRect();

                    // Настраиваем canvas для анимации
                    const canvas = document.querySelector('.confetti-canvas');
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;

                    // Запускаем анимацию конфетти рядом с кнопкой
                    confetti({
                        particleCount: 50, // Количество сердечек
                        spread: 70, // Разброс
                        origin: {
                            x: (buttonRect.left + buttonRect.width / 2) / window.innerWidth, // Центр кнопки по X
                            y: (buttonRect.top + buttonRect.height / 2) / window.innerHeight // Центр кнопки по Y
                        },
                        shapes: ['heart'], // Форма сердечек
                        colors: ['#ff0000', '#ff6666', '#ff9999'], // Цвета сердечек
                        scalar: 0.8 // Масштаб сердечек
                    });
                } else {
                    likeIcon.setAttribute('fill', 'none'); // Пустая иконка
                }

                // Обновляем количество лайков
                likesCount.textContent = data.likesCount;
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        });
    });
});



</script>
