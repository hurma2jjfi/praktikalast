<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Панель администратора</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Big+Shoulders:opsz,wght@10..72,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

        .grid-3 table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .grid-3 th, .grid-3 td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #2d2d3e;
            background-color: #1A1A28; /* Фоновый цвет ячеек */
            color: #fff; /* Цвет текста */
        }

        .grid-3 th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        .grid-3 tbody tr:nth-child(even) {
            background-color: #1e1e2d; /* Чередование цветов строк */
        }

        .grid-3 tbody tr:hover {
            background-color: #33334d; /* Подсветка при наведении */
            transition: background-color 0.3s ease;
        }

        .grid-3 img {
            border-radius: 50%; /* Сделать аватар круглым */
            object-fit: cover; /* Обрезать аватар по кругу */
        }

        .grid-3 td:first-child {
            width: 70px; /* Ширина столбца с аватарами */
        }

        .grid-3 td:nth-child(2), .grid-3 td:nth-child(3) {
            width: 150px; /* Ширина столбцов с именем и фамилией */
        }

        .grid-3 td:nth-child(4), .grid-3 td:nth-child(5) {
            width: 150px; /* Ширина столбцов с логином и email */
        }

        .grid-3 td:nth-child(6) {
            width: 50px; /* Ширина столбца с админ статусом */
        }

        .grid-3 td:nth-child(7), .grid-3 td:nth-child(8), .grid-3 td:nth-child(9) {
            width: 150px; /* Ширина столбцов с датами */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-size: 16px;
            color: #ffffff;
            background-color: #0D0D17;
            font-family: "JetBrains Mono", monospace;
        }

        .sidebar__panel {
            width: 383px;
            height: 100%;
            background-color: #1A1A28;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 426px);
            grid-template-rows: 238px 730px auto auto; /*  Добавляем auto для высоты третьей строки  */
            gap: 15px;
            justify-content: center;
            padding: 48px;
            margin-left: 400px;
        }

        .grid-1 {
            background-color: #1A1A28;
            border-radius: 20px;
            border-left: 1px dashed #8128BC;
        }

        .grid-2 {
            background-color: #1A1A28;
            grid-column: 1 / 4;
            /* grid-row: 2 / 3;   Удаляем, так как теперь будет в третьей строке */
            border-radius: 20px;
            border-left: 1px dashed #8128BC;
        }

        .grid-3 {
            background-color: #1A1A28;
            grid-column: 1 / 4;
            /* grid-row: 3; Указываем, что элемент должен начинаться с третьей строки */
            border-radius: 20px;
            border-left: 1px dashed #8128BC;
            padding: 20px; /* Добавляем padding, чтобы контент не прилипал к краям */
            color: #fff;
        }

        /* Стиль для нового grid-элемента с графиком */
        .grid-4 {
            background-color: #1A1A28;
            grid-column: 1 / 4;
            border-radius: 20px;
            border-left: 1px dashed #8128BC;
            padding: 20px;
            color: #fff;
            height: 300px; /*  Установите желаемую высоту */
        }

        .grid-1, .grid-2, .grid-3, .grid-4 {
            transition: 0.9s;
        }

        .grid-1:hover, .grid-2:hover, .grid-3:hover, .grid-4:hover {
            transform: translateY(-10px);
        }

        .indicator {
            width: 2px;
            height: 100px;
            background-color: #8128BC;
            border-radius: 14px;
        }

        .title {
            font-size: 32px;
            color: #fff;
            font-weight: bolder;
        }

        .wrapper__menu {
            display: flex;
            gap: 27px;
            padding: 37px 0;
        }

        .stats h1 {
            text-transform: uppercase;
            font-weight: bolder;
            font-size: 32px;
        }

        .stats p {
            font-size: 96px;
            font-weight: 900;
        }

        .stats {
            padding: 29px 103px 30px 103px;
            text-align: center;
        }

        .form__wrapper {
            font-size: 20px;
            width: 389px; /* Ширина контейнера */
        }

        .form__wrapper .field__category {
    width: 100%; /* Ширина инпута */
    height: 43px;
    background: none;
    border: 1px solid #fff;
    border-radius: 20px;
    color: #fff;
    font-size: 16px;
    padding: 0 20px;
    font-family: "JetBrains Mono", monospace;
    outline: none;
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Добавляем переходы */
}

.form__wrapper .field__category::placeholder {
    color: #ccc;
    font-size: 16px;
    font-family: "JetBrains Mono", monospace;
    font-weight: lighter;
}

.form__wrapper .field__category:focus {
    border-color: #8128BC;
    border: 2px solid #8128BC;
    box-shadow: 0 0 0 0.2rem rgba(128, 40, 188, 0.25); 
    transition: 0.4s; 
}


        .radio__flex {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Две колонки */
            grid-template-rows: repeat(3, auto); /* Три ряда */
            gap: 20px; /* Отступ между элементами */
            width: 100%; /* Ширина, соответствующая ширине контейнера */
        }

        .field__category {
            grid-column: 1 / 3; /* Поле ввода занимает всю ширину */
            grid-row: 1; /* В первом ряду */
        }

        input[type="radio"] {
            display: none; /* Скрываем стандартные радиокнопки */
        }

        input[type="radio"] + label {
            position: relative;
            padding-left: 35px;
        }

        input[type="radio"] + label::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            width: 26px; /* Ширина кастомной радиокнопки */
            height: 26px; /* Высота кастомной радиокнопки */
            border-radius: 50%;
            background-color: #fff; /* Фоновый цвет кастомной радиокнопки */
            border: 1px solid #ccc; /* Граница кастомной радиокнопки */
        }

        input[type="radio"]:checked + label::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 4px;
            transform: translateY(-50%);
            width: 20px; /* Ширина выбранной радиокнопки */
            height: 20px; /* Высота выбранной радиокнопки */
            border-radius: 50%;
            background-color: #8128BC; /* Цвет выбранной радиокнопки */
        }

        input[type="radio"] + label {
            font-size: 19px; /* Размер шрифта для метки */
            color: #fff; /* Цвет текста метки */
        }

        .add-category {
            background-color: #8128BC;
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            width: 389px;
            height: 43px;
            padding: 0 20px;
            margin: 30px 0;
        }

        .add-category:hover {
            background-color: #8a0bd3;
            color: #fff;
            transition: 0.9s;
        }

        .title__add {
            font-size: 30px;
            margin-bottom: 40px;
        }

        .form {
            display: flex;
            justify-content: center;
            padding: 219px 505px;
        }

        .disabled {
            opacity: 0.5;
            pointer-events: none;
            cursor: not-allowed;
        }

        .field__category:disabled {
            background-color: #333;
            cursor: not-allowed;
        }

        input[type="radio"]:disabled + label {
            color: #666;
            cursor: not-allowed;
        }

        #logout-btn {
            width: 159px;
            height: 46px;
            background-color: #d30b1c;
            color: #fff;
            position: fixed;
            bottom: 0;
            left: 0;
            border: none;
            cursor: pointer;
            font-family: "JetBrains Mono", monospace;
            font-weight: 400;
            border-radius: 4px;
            margin: 0 112px 40px;
        }

        #logout-btn:hover {
            background-color: #860a1d;
            color: #fff;
            transition: 0.4s;
        }

        /* Стили для grid-3 */
        .grid-3 {
            background-color: #1A1A28;
            grid-column: 1 / 4;
            border-radius: 20px;
            border-left: 1px dashed #8128BC;
            padding: 20px;
            color: #fff;
        }

        .grid-4 canvas {
    display: block; /* canvas - строчный элемент, делаем блочным */
    margin: 0 auto; /* Автоматические поля слева и справа */
}

.tg-success-message {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background-color: #2ecc71; /* Зеленый цвет, как в Telegram */
    color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

.checkmark {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.checkmark-circle {
    stroke: #fff;
    stroke-dashoffset: 0;
    animation: draw-circle 0.5s forwards;
}

.checkmark-check {
    stroke: #fff;
    stroke-dashoffset: 0;
    animation: draw-check 0.5s forwards;
}

@keyframes draw-circle {
    0% {
        stroke-dashoffset: 330;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes draw-check {
    0% {
        stroke-dashoffset: 60;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

.message {
    font-size: 16px;
    font-weight: bold;
}


.tg-success-message {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.tg-success-message.show {
    opacity: 1;
}

#ban {
    padding: 10px 20px; 
    color: #fff; 
    background-color: #ff0a0a; 
    font-size: 16px;
    border: none;
    border-radius: 5px; 
    font-family: "JetBrains Mono", monospace; 
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#ban:hover {
    background-color: #000000; /* Цвет фона при наведении */
}


#unBan {
    padding: 10px 15px; /* Увеличиваем отступы для большего удобства */
    color: #fff; /* Цвет текста белый */
    background-color: #0088cc; /* Цвет фона, аналогичный цвету Telegram */
    font-size: 16px; /* Размер шрифта */
    border: none; /* Без границы */
    border-radius: 5px; /* Скругленные углы */
    font-family: "JetBrains Mono", monospace; /* Шрифт JetBrains Mono */
    cursor: pointer; /* Курсор при наведении */
    transition: background-color 0.3s ease; /* Плавный переход цвета фона */
}

#unBan:hover {
    background-color: #007bb5; /* Цвет фона при наведении */
}



        .wrapperGetCategory {
            display: none;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
            background-color: #1A1A28;
            border-radius: 20px;
            border-left: 1px dashed #8128BC;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .category-card {
            background-color: #2d2d3e;
            border-radius: 10px;
            padding: 15px;
            color: #fff;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .tab {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #1A1A28;
            border-radius: 10px;
            margin-bottom: 25px;
            color: #fff;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .tab.active {
            background-color: #8128BC;
        }

        .tab:hover {
            background-color: #8128BC;
        }

        .text-center {
            margin-bottom: 20px;
            margin-top: 20px;
        }

        


        
    </style>
</head>
<body>

    {{-- //Навигационное меню мое --}}
    <div class="sidebar__panel">
        <div class="wrapper__menu">
            <div class="indicator"></div>
            <div class="title">Панель<br> администратора</div>
        </div>
    </div>

    <div class="grid-container">
        <div class="grid grid-1">
            <div class="stats">
                <p>{{ $userCount }}</p>
                <h1>пользователей</h1>
            </div>
        </div>
        <div class="grid grid-1">
            <div class="stats">
                <p>{{ $postCount }}</p>
                <h1>постов</h1>
            </div>
        </div>
        <div class="grid grid-1">
            <div class="stats">
                <p>{{ $likeCount }}</p>
                <h1>лайков</h1>
            </div>
        </div>
        <div class="grid grid-2">
            <div class="form">
                <div class="form__wrapper">
                    <h1 class="title__add">Добавить категории</h1>
                    <form action="{{ route('admin.addCategory') }}" method="POST">
                        @csrf
                        <div class="radio__flex">
                            <input type="text" class="field__category" name="name" placeholder="Категория">
                            <input type="radio" id="option1" name="options" value="option1">
                            <label for="option1">Категория 1</label>
                            <input type="radio" id="option2" name="options" value="option2">
                            <label for="option2">Категория 2</label>
                            <input type="radio" id="option3" name="options" value="option3">
                            <label for="option3">Категория 3</label>
                            <input type="radio" id="option4" name="options" value="option4">
                            <label for="option4">Категория 4</label>
                        </div>
                        <button class="add-category" type="submit">Добавить</button>
                        @if(session('success'))
    <div class="tg-success-message">
        <div class="checkmark">
            <img style="display: flex; align-items: center; margin:10px 0;" src="{{ asset('assets/succ.svg') }}">
        </div>
        <div class="message">{{ session('success') }}</div>
    </div>
@endif

                    </form>
                </div>
            </div>

        
                <!-- Табы для управления видимостью категорий -->
                <div class="tab" onclick="toggleCategories()">Показать все категории</div>
        
                <!-- Контейнер для категорий -->
                <div class="wrapperGetCategory" id="categoriesContainer">
                    @foreach($categories as $category)
                        <div class="category-card">
                            {{ $category->name }}
                        </div>
                    @endforeach
              
        </div>
        
       


        <div class="grid grid-3">
            <h1>Список пользователей:</h1>
            <table>
                <thead>
                    <tr>
                        <th>Аватар:</th>
                        <th>Имя:</th>
                        <th>Фамилия:</th>
                        <th>Логин:</th>
                        <th>Email:</th>
                        <th>Роль:</th>
                        <th>Создан:</th>
                        <th>Обновлен:</th>
                        <th>Последняя активность:</th>
                        <th>Действия:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                @if($user->userInfo->avatar)
                                    <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" width="50" height="50">
                                @else
                                    <span>Нет аватара</span>
                                @endif
                            </td>
                            <td>{{ $user->userInfo->first_name ?? '' }}</td>
                            <td>{{ $user->userInfo->last_name ?? '' }}</td>
                            <td>{{ $user->login ?? $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>{{ $user->last_activity_at }}</td>
                            <td>
                                @if($user->is_banned)
                                    <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button id="unBan" type="submit">Разблокировать</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.banUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button id="ban" type="submit">Заблокировать</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Добавляем новый grid-элемент для графика --}}
      
        <div class="text-center"><h1>Графики</h1></div>

        <div class="grid grid-4">
            <canvas width="520" height="260" id="userChart"></canvas>
        </div>
        <div class="grid grid-4">
            <canvas width="520" height="260" id="postChart"></canvas>
        </div>
        <div class="grid grid-4">
            <canvas width="520" height="260" id="likeChart"></canvas>
        </div>

    </div>

    <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button id="logout-btn" type="submit" class="flex items-center">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span>Выйти</span>
        </button>
    </form>


    





    <script>

        
            function toggleCategories() {
            const categoriesContainer = document.getElementById('categoriesContainer');
            const tab = document.querySelector('.tab');

            if (categoriesContainer.style.display === 'none' || categoriesContainer.style.display === '') {
                categoriesContainer.style.display = 'grid';
                tab.classList.add('active');
            } else {
                categoriesContainer.style.display = 'none';
                tab.classList.remove('active');
            }
        }




const dpr = window.devicePixelRatio || 1;

function adjustCanvas(canvas, width, height) {
    canvas.width = width * dpr;
    canvas.height = height * dpr;
    canvas.style.width = width + 'px';
    canvas.style.height = height + 'px';
    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);
}

document.addEventListener('DOMContentLoaded', function() {
    const userChartCanvas = document.getElementById('userChart');
    const postChartCanvas = document.getElementById('postChart');
    const likeChartCanvas = document.getElementById('likeChart');

    adjustCanvas(userChartCanvas, 520, 260);
    adjustCanvas(postChartCanvas, 520, 260);
    adjustCanvas(likeChartCanvas, 520, 260);

    //  Данные для графика пользователей
    const userCount = {{ $userCount }};
    const userData = {
        labels: ['Пользователи'],
        datasets: [{
            label: 'Количество пользователей',
            data: [userCount],
            fill: false,
            backgroundColor: ['#8128BC'],
            borderColor: '#8128BC',
            borderWidth: 1,
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: 'white',
                font: {
                    size: 16
                },
                formatter: function(value, context) {
                    return value;
                }
            }
        }]
    };

    const userConfig = {
        type: 'bar',
        data: userData,
        options: {
            devicePixelRatio: dpr,
            indexAxis: 'x',
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: 'white',
                    font: {
                        size: 16
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                },
                tooltip: {
                    backgroundColor: '#1A1A28',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: '#8128BC',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        },
                        title: function(context) {
                            return 'Всего пользователей';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        display: false,
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    };

    const userChart = new Chart(
        userChartCanvas,
        userConfig
    );

     // Данные для графика постов
     const postCount = {{ $postCount }};
    const postData = {
        labels: ['Посты'],
        datasets: [{
            label: 'Количество постов',
            data: [postCount],
            fill: false,
            backgroundColor: ['#36a2eb'],
            borderColor: '#36a2eb',
            borderWidth: 1,
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: 'white',
                font: {
                    size: 16
                },
                formatter: function(value, context) {
                    return value;
                }
            }
        }]
    };

    const postConfig = {
        type: 'bar',
        data: postData,
        options: {
            devicePixelRatio: dpr,
            indexAxis: 'x',
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: 'white',
                    font: {
                        size: 16
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                },
                tooltip: {
                    backgroundColor: '#1A1A28',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: '#36a2eb',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        },
                        title: function(context) {
                            return 'Всего постов';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        display: false,
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    };

    const postChart = new Chart(
        postChartCanvas,
        postConfig
    );

    // Данные для графика лайков
    const likeCount = {{ $likeCount }};
    const likeData = {
        labels: ['Лайки'],
        datasets: [{
            label: 'Количество лайков',
            data: [likeCount],
            fill: false,
            backgroundColor: ['#4bc0c0'],
            borderColor: '#4bc0c0',
            borderWidth: 1,
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: 'white',
                font: {
                    size: 16
                },
                formatter: function(value, context) {
                    return value;
                }
            }
        }]
    };

    const likeConfig = {
        type: 'bar',
        data: likeData,
        options: {
            devicePixelRatio: dpr,
            indexAxis: 'x',
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: 'white',
                    font: {
                        size: 16
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                },
                tooltip: {
                    backgroundColor: '#1A1A28',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: '#4bc0c0',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        },
                        title: function(context) {
                            return 'Всего лайков';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        display: false,
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    };

    const likeChart = new Chart(
        likeChartCanvas,
        likeConfig
    );
});

document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.querySelector('.tg-success-message');
    if (successMessage) {
        setTimeout(function() {
            successMessage.classList.add('show');
        }, 100);
    }
});

    </script>



</body>
</html>
