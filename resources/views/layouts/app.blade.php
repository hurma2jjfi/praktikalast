<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Singlegram Web</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">СоцСеть</a>
            <div>
                @auth
                    <a href="{{ route('profile.show') }}" class="mr-4">Профиль</a>
                    <a href="{{ route('news.index') }}" class="mr-4">Новости</a>
                    <a href="{{ route('friends.index') }}" class="mr-4">Друзья</a>
                    <a href="{{ route('chats.index') }}" class="mr-4">Сообщения</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mr-4">Войти</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>
    </nav>

    

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <footer class="bg-blue-600 text-white p-6 mt-8">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <p>&copy; {{ date('Y') }} СоцСеть. Все права защищены.</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('news.index') }}" class="hover:text-blue-400">Новости</a>
                <a href="{{ route('friends.index') }}" class="hover:text-blue-400">Друзья</a>
                <a href="{{ route('chats.index') }}" class="hover:text-blue-400">Сообщения</a>
                <a href="{{ route('profile.show') }}" class="hover:text-blue-400">Профиль</a>
            </div>
        </div>
    </footer>


    <style>
       html, body {
    height: 100%; /* Устанавливаем высоту на 100% для корректной работы flexbox */
    margin: 0; /* Убираем отступы */
}

body {
    display: flex;
    flex-direction: column; /* Располагаем элементы вертикально */
}

main {
    flex-grow: 1; /* Заставляем основной контент занимать все доступное пространство */
}
    </style>

   
</body>
</html>