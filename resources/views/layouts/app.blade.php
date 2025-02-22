{{-- <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Singlegram Web</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // Проверяем сохранённую тему в localStorage
        const savedTheme = localStorage.getItem('theme');

        // Применяем тему сразу при загрузке страницы
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100">
    <nav id="navbar" class="nav-light p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">СоцСеть</a>
            <div class="flex items-center">
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
                <!-- Кнопка переключения темы -->
                <button id="theme-toggle" class="ml-4 p-2 rounded-full hover:bg-blue-700">
                    <i id="theme-icon" class="fas fa-moon"></i> <!-- Иконка для тёмной темы -->
                </button>
            </div>
        </div>
    </nav>

    

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <footer id="footer" class="footer-light p-6 mt-8">
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
    height: 100%; 
    margin: 0; 
}

body {
    display: flex;
    flex-direction: column;
}

main {
    flex-grow: 1; 
}

body.dark {
    background-color: #2c2b2b;
    color: #f3f4f6;
}

body.dark strong,
body.dark h1,
body.dark p {
    color: inherit; 
}

   
    .nav-light {
        background-color: #2563eb; 
        color: #ffffff; 
    }

    .nav-dark {
        background-color: #1e40af; 
        color: #ffffff; 
    }

  
    .footer-light {
        background-color: #2563eb; 
        color: #ffffff;
    }

    .footer-dark {
        background-color: #1e40af; 
        color: #ffffff; 
    }
    </style>

<script>

    function toggleTheme() {
        const body = document.body;
        const navbar = document.getElementById('navbar');
        const footer = document.getElementById('footer');
        const themeIcon = document.getElementById('theme-icon');

        if (body.classList.contains('dark')) {

            body.classList.remove('dark');
            navbar.classList.remove('nav-dark');
            navbar.classList.add('nav-light');
            footer.classList.remove('footer-dark');
            footer.classList.add('footer-light');
            localStorage.setItem('theme', 'light');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
    
            body.classList.add('dark');
            navbar.classList.remove('nav-light');
            navbar.classList.add('nav-dark');
            footer.classList.remove('footer-light');
            footer.classList.add('footer-dark');
            localStorage.setItem('theme', 'dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
    }


    function loadTheme() {
        const savedTheme = localStorage.getItem('theme');
        const body = document.body;
        const navbar = document.getElementById('navbar');
        const footer = document.getElementById('footer');
        const themeIcon = document.getElementById('theme-icon');

        if (savedTheme === 'dark') {
            body.classList.add('dark');
            navbar.classList.remove('nav-light');
            navbar.classList.add('nav-dark');
            footer.classList.remove('footer-light');
            footer.classList.add('footer-dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            body.classList.remove('dark');
            navbar.classList.remove('nav-dark');
            navbar.classList.add('nav-light');
            footer.classList.remove('footer-dark');
            footer.classList.add('footer-light');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    }

    
    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);


    window.addEventListener('load', loadTheme);
</script>
</body>
</html> --}}

{{-- //сайдбар старый код долой старый хэдэр зло --}}

{{-- <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Singlegram Web</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // Проверяем сохранённую тему в localStorage
        const savedTheme = localStorage.getItem('theme');

        // Применяем тему сразу при загрузке страницы
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Кнопка для открытия/закрытия сайдбара -->
    <button id="sidebar-toggle" class="fixed top-4 left-4 z-50 p-2 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Сайдбар -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-blue-600 text-white transform -translate-x-full transition-transform duration-300 ease-in-out z-40 dark:bg-gray-800">
        <div class="p-4 border-b border-blue-700 dark:border-gray-700">
            <a href="/" class="text-xl font-bold flex items-center">
                <i class="fas fa-users mr-2"></i>
                <span>СоцСеть</span>
            </a>
        </div>
        <nav class="mt-4">
            <ul>
                @auth
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <a href="{{ route('profile.show') }}" class="block flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span>Профиль</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <a href="{{ route('news.index') }}" class="block flex items-center">
                            <i class="fas fa-newspaper mr-2"></i>
                            <span>Новости</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <a href="{{ route('friends.index') }}" class="block flex items-center">
                            <i class="fas fa-user-friends mr-2"></i>
                            <span>Друзья</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <a href="{{ route('chats.index') }}" class="block flex items-center">
                            <i class="fas fa-comments mr-2"></i>
                            <span>Сообщения</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Выйти</span>
                            </button>
                        </form>
                    </li>
                @else
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <a href="{{ route('login') }}" class="block flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span>Войти</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-blue-700 dark:hover:bg-gray-700">
                        <a href="{{ route('register') }}" class="block flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span>Регистрация</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
        <!-- Кнопка переключения темы -->
        <div class="absolute bottom-4 left-4">
            <button id="theme-toggle" class="p-2 rounded-full hover:bg-blue-700 dark:hover:bg-gray-700">
                <i id="theme-icon" class="fas fa-moon"></i>
            </button>
        </div>
    </aside>

    <!-- Основной контент -->
    <main class="container mx-auto p-4 transition-all duration-300 ease-in-out">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer id="footer" class="footer-light p-6 mt-8 dark:bg-gray-800 dark:text-white">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <p>&copy; {{ date('Y') }} СоцСеть. Все права защищены.</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('news.index') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Новости</a>
                <a href="{{ route('friends.index') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Друзья</a>
                <a href="{{ route('chats.index') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Сообщения</a>
                <a href="{{ route('profile.show') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Профиль</a>
            </div>
        </div>
    </footer>

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex-grow: 1;
        }

        /* Анимация для сайдбара */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        #sidebar-toggle {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .footer-light {
            color: #fff;
        }
    </style>

    <script>
        // Функция для переключения темы
        function toggleTheme() {
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const footer = document.getElementById('footer');
            const themeIcon = document.getElementById('theme-icon');

            if (body.classList.contains('dark')) {
                body.classList.remove('dark');
                sidebar.classList.remove('dark:bg-gray-800');
                sidebar.classList.add('bg-blue-600');
                footer.classList.remove('dark:bg-gray-800');
                footer.classList.add('bg-blue-600');
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            } else {
                body.classList.add('dark');
                sidebar.classList.remove('bg-blue-600');
                sidebar.classList.add('dark:bg-gray-800');
                footer.classList.remove('bg-blue-600');
                footer.classList.add('dark:bg-gray-800');
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }

        // Функция для открытия/закрытия сайдбара
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Проверка сохранённой темы при загрузке страницы
        function loadTheme() {
            const savedTheme = localStorage.getItem('theme');
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const footer = document.getElementById('footer');
            const themeIcon = document.getElementById('theme-icon');

            if (savedTheme === 'dark') {
                body.classList.add('dark');
                sidebar.classList.remove('bg-blue-600');
                sidebar.classList.add('dark:bg-gray-800');
                footer.classList.remove('bg-blue-600');
                footer.classList.add('dark:bg-gray-800');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                body.classList.remove('dark');
                sidebar.classList.remove('dark:bg-gray-800');
                sidebar.classList.add('bg-blue-600');
                footer.classList.remove('dark:bg-gray-800');
                footer.classList.add('bg-blue-600');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        // Назначение обработчиков событий
        document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
        document.getElementById('sidebar-toggle').addEventListener('click', toggleSidebar);

        // Загрузка темы при загрузке страницы
        window.addEventListener('load', loadTheme);
    </script>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teslagram Web</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // Проверяем сохранённую тему в localStorage
        const savedTheme = localStorage.getItem('theme');

        // Применяем тему сразу при загрузке страницы
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Сайдбар -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-white text-gray-800 shadow-lg z-40 dark:bg-gray-800 dark:text-gray-200">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <a href="/" class="text-xl font-bold flex items-center">
                {{-- <i class="fas fa-users mr-2"></i>
                <span>Singlegram</span> --}}
                <img width="150" height="150" src="{{ asset('assets/logopt2dark.svg') }}" alt="Logo">
            </a>
        </div>
        <nav class="mt-4">
            <ul>
                @auth
                    <!-- Аватар и имя пользователя -->
                    <li class="px-4 py-3 flex items-center space-x-3">
                       
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('profile.show') }}" class="block flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span>Профиль</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('news.index') }}" class="block flex items-center">
                            <i class="fas fa-newspaper mr-2"></i>
                            <span>Новости</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('friends.index') }}" class="block flex items-center">
                            <i class="fas fa-user-friends mr-2"></i>
                            <span>Друзья</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('chats.index') }}" class="block flex items-center">
                            <i class="fas fa-comments mr-2"></i>
                            <span>Сообщения</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Выйти</span>
                            </button>
                        </form>
                    </li>
                @else
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('login') }}" class="block flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span>Войти</span>
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('register') }}" class="block flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span>Регистрация</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
        <!-- Кнопка переключения темы -->
        <div class="absolute bottom-4 left-4">
            <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <i id="theme-icon" class="fas fa-moon"></i>
            </button>
        </div>
    </aside>

    <!-- Основной контент -->
    <main class="ml-64 p-4 transition-all duration-300 ease-in-out">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer id="footer" class="ml-64 p-6 mt-8 bg-white dark:bg-gray-800 dark:text-white">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <p>&copy; {{ date('Y') }} СоцСеть. Все права защищены.</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('news.index') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Новости</a>
                <a href="{{ route('friends.index') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Друзья</a>
                <a href="{{ route('chats.index') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Сообщения</a>
                <a href="{{ route('profile.show') }}" class="hover:text-blue-400 dark:hover:text-gray-400">Профиль</a>
            </div>
        </div>
    </footer>

    <style>
   
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

main {
    flex-grow: 1;
}


body.dark {
    background-color: #1e1e1e; 
    color: #ffffff; 
}


body.dark #sidebar,
body.dark #sidebar a {
    color: #ffffff; 
}

#theme-toggle {
    border-radius: 50%;
    width: 40px;
    height: 40px;
}


.nav-light,
.footer-light {
    background-color: #2563eb;
    color: #ffffff;
}

.nav-dark,
.footer-dark {
    background-color: #1e40af;
    color: #ffffff;
}


#sidebar {
    transition: transform 0.3s ease-in-out;
}

#sidebar.open {
    transform: translateX(0);
}


#sidebar-toggle {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}


html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

main {
    flex-grow: 1;
}


body.dark {
    background-color: #1e1e1e;
    color: #ffffff;
}


body.dark #sidebar,
body.dark #sidebar a {
    color: #ffffff;
}



body.dark #theme-toggle:hover {
    background-color: rgba(255, 255, 255, 0.2); 
}



.nav-light,
.footer-light {
    background-color: #2563eb;
    color: #ffffff;
}

.nav-dark,
.footer-dark {
    background-color: #1e40af;
    color: #ffffff;
}


#sidebar {
    transition: transform 0.3s ease-in-out;
}

#sidebar.open {
    transform: translateX(0);
}


body.dark li:hover {
    background-color: rgba(59, 58, 58, 0.2);
}




    </style>

    <script>
 
        function toggleTheme() {
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const footer = document.getElementById('footer');
            const themeIcon = document.getElementById('theme-icon');

            if (body.classList.contains('dark')) {
                body.classList.remove('dark');
                sidebar.classList.remove('dark:bg-gray-800');
                sidebar.classList.add('bg-white');
                footer.classList.remove('dark:bg-gray-800');
                footer.classList.add('bg-white');
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            } else {
                body.classList.add('dark');
                sidebar.classList.remove('bg-white');
                sidebar.classList.add('dark:bg-gray-800');
                footer.classList.remove('bg-white');
                footer.classList.add('dark:bg-gray-800');
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }

       
        function setActiveMenuItem() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('#sidebar nav a');

            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.parentElement.classList.add('active-menu-item');
                } else {
                    item.parentElement.classList.remove('active-menu-item');
                }
            });
        }

       
        document.getElementById('theme-toggle').addEventListener('click', toggleTheme);

  
        window.addEventListener('load', () => {
            const savedTheme = localStorage.getItem('theme');
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const footer = document.getElementById('footer');
            const themeIcon = document.getElementById('theme-icon');

            if (savedTheme === 'dark') {
                body.classList.add('dark');
                sidebar.classList.remove('bg-white');
                sidebar.classList.add('dark:bg-gray-800');
                footer.classList.remove('bg-white');
                footer.classList.add('dark:bg-gray-800');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                body.classList.remove('dark');
                sidebar.classList.remove('dark:bg-gray-800');
                sidebar.classList.add('bg-white');
                footer.classList.remove('dark:bg-gray-800');
                footer.classList.add('bg-white');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }

            setActiveMenuItem();
        });
    </script>
</body>
</html>