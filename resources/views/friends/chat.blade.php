@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Чат с {{ '@' . $user->login }}</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    

    <!-- Статус пользователя (отображается один раз вверху) -->
    <div class="bg-white p-4 rounded-lg border border-gray-200 mb-4">
        <div class="flex items-center mb-4">
            <!-- Аватарка пользователя с градиентной границей -->
            <div class="relative w-10 h-10 rounded-full mr-3 gradient-border">
                @if ($user->userInfo && $user->userInfo->avatar)
                    <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                @else
                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                        <p class="text-gray-500 text-xs">Аватар</p>
                    </div>
                @endif
            </div>

            
            <!-- Имя пользователя, индикатор статуса и время последней активности -->
            <div>
                <p class="font-bold">{{ $firstName }} {{ $lastName }}</p>
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

        <!-- Контейнер для кнопки поиска и инпута -->
        <div class="flex justify-end mb-4">
            <div id="searchWrapper" class="relative">
                <!-- Кнопка для открытия поиска -->
                <button id="openSearch" class="p-2 text-gray-500 hover:text-blue-500 transition-colors">
                    <i class="fas fa-search"></i> <!-- Иконка поиска -->
                </button>
        
                <!-- Инпут поиска (изначально скрыт) -->
                <input type="text" id="searchMessages" placeholder="Поиск сообщений..."
                       class="absolute top-0 right-0 w-0 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-all duration-300"
                       style="opacity: 0; visibility: hidden;">
            </div>
        </div>

        
        <!-- Список сообщений -->
        <div class="space-y-4" id="messagesContainer">
            @if ($messages->isEmpty())
                <div class="text-center text-gray-500">
                    Пока нет сообщений.
                </div>
            @else
                @php
                    $currentDate = null;
                @endphp

                @foreach($messages as $message)
                    @php
                        $messageDate = $message->created_at->format('Y-m-d');
                    @endphp

                    @if ($messageDate !== $currentDate)
                        @php
                            $currentDate = $messageDate;
                            $dateText = getRelativeDate($message->created_at);
                        @endphp

                        <div class="text-date-center">
                            <div class="date-label text-center text-white-500 mb-2">
                                {{ $dateText }}
                            </div>
                        </div>
                    @endif

                    <div class="group flex items-start message {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <!-- Аватарка пользователя -->
                        @if ($message->user_id != Auth::id())
                            <div class="relative w-8 h-8 rounded-full mr-3 gradient-border">
                                @if ($message->user->userInfo && $message->user->userInfo->avatar)
                                    <img src="{{ asset('storage/' . $message->user->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <p class="text-gray-500 text-xs">Аватар</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Сообщение и информация о пользователе -->
                        <div class="max-w-[70%] relative">
                            <!-- Текст сообщения -->
                            <div class="p-3 rounded-lg {{ $message->user_id == Auth::id() ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left' }}">
                                <p>{{ $message->content }}</p>
                                <div class="justify-end">
                                    <small class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                            <!-- Время отправки сообщения и индикатор прочтения -->
                            <div class="mt-1 flex items-center {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                @if ($message->user_id == Auth::id())
                                    <span class="ml-2">
                                        @if ($message->read_at)
                                            <i class="fas fa-check text-green-500"></i>
                                        @else
                                            <i class="fas fa-check text-gray-400"></i>
                                        @endif
                                    </span>
                                @endif
                            </div>

                            <!-- Кнопка удаления (появляется при наведении) -->
                            @if ($message->user_id == Auth::id())
                                <form method="POST" action="{{ route('friends.deleteMessage', $message) }}" class="absolute -right-6 top-12 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-500">
                                        <i class="fas fa-trash-alt"></i> <!-- Иконка корзины -->
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Аватарка текущего пользователя (если сообщение его) -->
                        @if ($message->user_id == Auth::id())
                            <div class="relative w-8 h-8 rounded-full ml-3 gradient-border">
                                @if (Auth::user()->userInfo && Auth::user()->userInfo->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->userInfo->avatar) }}" alt="Аватар" class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <p class="text-gray-500 text-xs">Аватар</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Сообщение "Ничего не найдено" -->
        <div id="noResultsMessage" class="text-center text-gray-500 hidden">
            Ничего не найдено.
        </div>
    </div>

    <!-- Форма отправки сообщения -->
    <form method="POST" action="{{ route('friends.sendMessage', $user) }}" class="mt-4">
        @csrf
        <div class="flex items-center gap-2">
            <input type="text" name="content" placeholder="Введите сообщение" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Отправить</button>
        </div>
    </form>
@endsection

@php
    function getRelativeDate($date) {
        $now = now();
        $diff = $now->diffInDays($date);

        if ($diff == 0) {
            return 'Сегодня';
        } elseif ($diff == 1) {
            return 'Вчера';
        } else {
            return $date->format('F d'); // Добавляем число к месяцу
        }
    }
@endphp

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

    .date-label {
        background-color: #000000e5;
        color: #fff;
        padding: 4px 8px;
        border-radius: 24px;
        font-size: 12px;
        width: 100px;
        text-align: center;
    }

    .text-date-center {
        display: flex;
        justify-content: center;
    }

    .highlight {
        background-color: rgba(188, 24, 136, 0.1); /* Цвет выделения блока, как в Telegram */
        border-radius: 8px; /* Закругление углов */
    }

    .hidden {
        display: none; /* Скрываем элемент */
    }

    /* Компактный инпут */
    #searchMessages {
        width: 200px; /* Уменьшаем ширину инпута */
        padding: 6px 12px; /* Уменьшаем отступы */
        font-size: 14px; /* Уменьшаем размер текста */
    }

    /* Иконка поиска */
    #openSearch {
        font-size: 18px; /* Размер иконки */
    }

    @keyframes expandInput {
        0% {
            width: 0;
            opacity: 0;
        }
        100% {
            width: 200px;
            opacity: 1;
        }
    }

    /* Анимация сворачивания инпута */
    @keyframes collapseInput {
        0% {
            width: 200px;
            opacity: 1;
        }
        100% {
            width: 0;
            opacity: 0;
        }
    }

    /* Анимация иконки */
    @keyframes iconToInput {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(0);
            opacity: 0;
        }
    }

    @keyframes inputToIcon {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Применение анимаций */
    #searchMessages.expand {
        animation: expandInput 0.3s ease forwards;
    }

    #searchMessages.collapse {
        animation: collapseInput 0.3s ease forwards;
    }

    #openSearch.iconToInput {
        animation: iconToInput 0.3s ease forwards;
    }

    #openSearch.inputToIcon {
        animation: inputToIcon 0.3s ease forwards;
    }

    /* Стили для кнопки и инпута */
    #openSearch {
        font-size: 18px;
        transition: transform 0.3s ease, opacity 0.3s ease; /* Плавное изменение */
    }

    #searchMessages {
        width: 0;
        opacity: 0;
        transition: width 0.3s ease, opacity 0.3s ease; /* Плавное изменение */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const openSearchButton = document.getElementById('openSearch');
    const searchInput = document.getElementById('searchMessages');
    const searchWrapper = document.getElementById('searchWrapper');

    openSearchButton.addEventListener('click', function() {
        // Задаём ширину инпута
        searchInput.style.width = '200px';
        searchInput.style.opacity = '1';
        searchInput.style.visibility = 'visible';
        searchInput.focus();
    });

    searchInput.addEventListener('blur', function() {
        if (searchInput.value === '') {
            searchInput.style.width = '0';
            searchInput.style.opacity = '0';
            searchInput.style.visibility = 'hidden';
        }
    });

    const messagesContainer = document.getElementById('messagesContainer');
    const noResultsMessage = document.getElementById('noResultsMessage');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const messages = messagesContainer.querySelectorAll('.message');
        let foundResults = false;

        if (searchTerm === '') {
            messages.forEach(message => {
                message.style.visibility = 'visible';
                message.classList.remove('highlight');
            });
            noResultsMessage.classList.add('hidden');
            return;
        }

        messages.forEach(message => {
            const text = message.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                message.style.visibility = 'visible';
                message.classList.add('highlight');
                foundResults = true;
            } else {
                message.style.visibility = 'hidden';
                message.classList.remove('highlight');
            }
        });

        if (foundResults) {
            noResultsMessage.classList.add('hidden');
        } else {
            noResultsMessage.classList.remove('hidden');
        }
    });
});



</script>
