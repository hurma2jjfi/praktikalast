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

        <!-- Список сообщений -->
        <div class="space-y-4">
            @if ($messages->isEmpty())
                <p class="text-gray-500">Пока нет сообщений.</p>
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
                            // Используйте правильный путь к классу
                            $dateText = \App\Helpers\DateHelper::getRelativeDate($message->created_at);
                        @endphp

                        <div class="text-date-center">
                            <div class="date-label text-center text-white-500 mb-2">
                                {{ $dateText }}
                            </div>
                        </div>
                    @endif

                    <div class="group flex items-start {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
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
                            <div class="p-2 rounded-lg {{ $message->user_id == Auth::id() ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left' }}">
                                <p>{{ $message->content }}</p>
                                <div class="justify-end">
                                    <div class="flex__wrp__time">
                                    <small class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</small>
                                    <div class="flex items-center {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
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
                                    </div>
                                </div>
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

<style>

    .flex__wrp__time {
        display: flex;
    }

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
</style>
