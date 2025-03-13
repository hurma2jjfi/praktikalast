<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teslagram Web</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
          @media (max-width: 1024px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.open {
                transform: translateX(0);
            }

            main {
                margin-left: 0;
            }

            footer {
                margin-left: 0;
            }
        }

        /* Общие стили для светлой темы */
        body {
            background-color: #ffffff;
            color: #000000;
        }

        /* Стили для темной темы */
        body.dark {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        /* Стили для текста в темной теме */
        body.dark a,
        body.dark span,
        body.dark p,
        body.dark h1,
        body.dark h2,
        body.dark h3,
        body.dark h4,
        body.dark h5,
        body.dark h6,
        body.dark li,
        body.dark .text-gray-800 {
            color: #ffffff;
        }

        /* Стили для текста в светлой теме */
        body a,
        body span,
        body p,
        body h1,
        body h2,
        body h3,
        body h4,
        body h5,
        body h6,
        body li,
        body .text-gray-800 {
            color: #000000;
        }

        /* Стили для сайдбара и футера в темной теме */
        body.dark #sidebar,
        body.dark #footer {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        /* Стили для сайдбара и футера в светлой теме */
        body #sidebar,
        body #footer {
            background-color: #ffffff;
            color: #000000;
        }

        /* Стили для кнопок в темной теме */
        body.dark .bg-gray-100 {
            background-color: #2d2d2d;
        }

        body.dark .hover\:bg-gray-100:hover {
            background-color: #3d3d3d;
        }

        /* Стили для кнопок в светлой теме */
        body .bg-gray-100 {
            background-color: #f3f4f6;
        }

        body .hover\:bg-gray-100:hover {
            background-color: #e5e7eb;
        }


    </style>
</head>
<div id="loading-bar" class="fixed top-0 left-0 h-1 bg-blue-500 z-50" style="width: 0%;"></div>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Кнопка бургер-меню -->
    <button id="sidebar-toggle" class="fixed top-4 left-6 p-2 bg-black text-white rounded-lg leading-none z-50 lg:hidden">
        <i class="fas fa-bars"></i>
    </button>


    <!-- Сайдбар -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-white text-gray-800 shadow-lg z-40 dark:bg-gray-800 dark:text-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <a href="/" class="text-xl font-bold flex items-center">
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
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 relative">
                        <a href="{{ route('chats.index') }}" class="block flex items-center">
                            <i class="fas fa-comments mr-2"></i>
                            <span>Сообщения</span>
                        </a>
                        @auth
                            @if ($totalUnreadCount > 0)
                                <span class="absolute top-1 right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $totalUnreadCount }}
                                </span>
                            @endif
                        @endauth
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <a href="{{ route('audio.index') }}" class="block flex items-center">
                            <i class="fas fa-music mr-2"></i>
                            <span>Музыка</span>
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
    <main class="py-16 px-6 transition-all duration-300 ease-in-out lg:ml-64">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer id="footer" class="p-6 mt-8 bg-white dark:bg-gray-800 dark:text-white lg:ml-64">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="/" class="text-xl font-bold flex items-center">
                    <img width="150" height="150" src="{{ asset('assets/logopt2dark.svg') }}" alt="Logo">
                </a>
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

#loading-bar {
    transition: width 0.3s ease;
}


    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const loadingBar = document.getElementById('loading-bar');

    // Функция для запуска загрузки
    function startLoading() {
        loadingBar.style.width = '50%';
    }

    // Функция для завершения загрузки
    function finishLoading() {
        loadingBar.style.width = '100%';
        setTimeout(() => {
            loadingBar.style.width = '0%';
        }, 300);
    }

    // Имитация загрузки при переходе по ссылкам
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function (e) {
            if (this.href && this.href !== '#' && !this.href.includes('javascript')) {
                startLoading();
                setTimeout(finishLoading, 1000); // Имитация загрузки
            }
        });
    });

    // Имитация загрузки при отправке форм
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            startLoading();
            setTimeout(finishLoading, 1000); // Имитация загрузки
        });
    });

    // Завершение загрузки при полной загрузке страницы
    window.addEventListener('load', function () {
        finishLoading();
    });
});

        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
            });


            document.addEventListener('click', function (event) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            });
        });


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


<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</body>
</html>
