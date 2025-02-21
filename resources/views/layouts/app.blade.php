<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Singlegram Web</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">СоцСеть</a>
            <div>
                @auth
                    <a href="{{ route('profile.show') }}" class="mr-4">Профиль</a>
                    <a href="{{ route('posts.index') }}" class="mr-4">Посты</a>
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


   
</body>
</html>