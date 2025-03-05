{{-- @extends('layouts.app')

@section('content')


    <div class="container mx-auto p-4">
        <!-- Кнопка "Создать новость" -->
        <a style="text-decoration: underline" href="{{ route('news.upload') }}">Добавить новость</a>
        <button id="create-news-button" class="fixed bottom-8 right-8 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>

        <!-- Модальное окно для создания новости -->
        <div id="news-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-full max-w-lg p-12 relative">
                <!-- Кнопка закрытия -->
                <button id="close-modal-button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <div class="ellipse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg></div>
                </button>

                <!-- Форма для создания новости -->
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Заголовок</label>
                        <input type="text" name="title" id="title" class="w-full p-2 border rounded" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700">Содержимое</label>
                        <textarea name="content" id="content" class="w-full p-2 border rounded resize-none" rows="5" placeholder="Что у вас нового?" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="media" class="block text-gray-700">Медиа (изображение или видео)</label>
                        <div class="relative w-64 h-64 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors cursor-pointer" id="media-upload">
                            <input type="file" name="media" id="media" class="hidden" accept=".jpg,.jpeg,.png,.gif,.mp4,.mov">
                            <div class="text-center" id="upload-prompt">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p id="media-name" class="text-gray-500 mt-2">Добавьте фото или видео</p>
                                <button type="button" class="mt-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors" onclick="document.getElementById('media').click()">Загрузить с устройства</button>
                            </div>
                            <div id="media-preview" class="hidden w-full h-full"></div>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white p-2 rounded">Опубликовать</button>
                </form>
            </div>
        </div>

        <!-- Лента новостей -->
        <h1 class="text-3xl font-bold mb-4">Лента новостей</h1>

        @if($news->isEmpty())
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <p class="text-gray-600">Нет новостей.</p>
            </div>
        @else
            @foreach($news as $item)
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <!-- Заголовок и контент -->
                    <h2 class="text-xl font-semibold mb-2">{{ $item->title }}</h2>
                    <p class="mb-4">{{ $item->content }}</p>

                    <!-- Медиа -->
                    @if($item->media_path)
                        @if(Str::endsWith($item->media_path, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/' . $item->media_path) }}" alt="Изображение" class="mt-2 rounded-lg w-full">
                        @elseif(Str::endsWith($item->media_path, ['mp4', 'mov']))
                            <video controls class="mt-2 rounded-lg w-full">
                                <source src="{{ asset('storage/' . $item->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @endif

                    <!-- Время публикации -->
                    <div class="flex justify-end mt-2">
                        <small class="text-gray-500">Опубликовано {{ $item->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        // Открытие модального окна
        document.getElementById('create-news-button').addEventListener('click', function() {
            document.getElementById('news-modal').classList.remove('hidden');
        });

        // Закрытие модального окна
        document.getElementById('close-modal-button').addEventListener('click', function() {
            document.getElementById('news-modal').classList.add('hidden');
        });

        // Обработка загрузки медиа
        document.getElementById('media').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const mediaName = document.getElementById('media-name');
                const uploadPrompt = document.getElementById('upload-prompt');
                const mediaPreview = document.getElementById('media-preview');

                mediaName.textContent = file.name;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        mediaPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg" alt="Загруженное медиа">`;
                        mediaPreview.classList.remove('hidden');
                        uploadPrompt.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    mediaPreview.innerHTML = `
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    `;
                    mediaPreview.classList.remove('hidden');
                    uploadPrompt.classList.add('hidden');
                }
            }
        });
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Кнопка "Создать новость" -->
        <a style="text-decoration: underline" href="{{ route('news.upload') }}">Добавить новость</a>
        <button id="create-news-button" class="fixed bottom-8 right-8 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>

        <!-- Модальное окно для создания новости -->
        <div id="news-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-full max-w-lg p-12 relative">
                <!-- Кнопка закрытия -->
                <button id="close-modal-button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <div class="ellipse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg></div>
                </button>

                <!-- Форма для создания новости -->
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h1 class="text-3xl font-bold mb-4 dark:text-white">Поделитесь новостью</h1>
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Заголовок</label>
                        <input type="text" name="title" id="title" class="w-full p-2 border rounded" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700">Содержимое</label>
                        <textarea name="content" id="content" class="w-full p-2 border rounded resize-none" rows="5" placeholder="Что у вас нового?" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="media" class="block text-gray-700">Медиа (изображение или видео)</label>
                        <div class="relative w-64 h-64 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors cursor-pointer" id="media-upload">
                            <input type="file" name="media" id="media" class="hidden" accept=".jpg,.jpeg,.png,.gif,.mp4,.mov">
                            <div class="text-center" id="upload-prompt">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p id="media-name" class="text-gray-500 mt-2">Добавьте фото или видео</p>
                                <button type="button" class="mt-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors" onclick="document.getElementById('media').click()">Загрузить с устройства</button>
                            </div>
                            <div id="media-preview" class="hidden w-full h-full"></div>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white p-2 rounded">Опубликовать</button>
                </form>
            </div>
        </div>

        <!-- Лента новостей -->
        <h1 class="text-3xl font-bold mb-4 dark:text-white">Лента новостей</h1>

        <!-- Контейнер для новостей -->
        <div id="news-feed" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Скелетоны для загрузки -->
            @for($i = 0; $i < 6; $i++)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4">
                    <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-4 animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full mb-2 animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-5/6 mb-4 animate-pulse"></div>
                    <div class="h-48 bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 animate-pulse"></div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/4 animate-pulse"></div>
                        <div class="flex space-x-4">
                            <div class="h-6 w-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse"></div>
                            <div class="h-6 w-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse"></div>
                            <div class="h-6 w-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <script>
        // Открытие модального окна
        document.getElementById('create-news-button').addEventListener('click', function() {
            document.getElementById('news-modal').classList.remove('hidden');
        });

        // Закрытие модального окна
        document.getElementById('close-modal-button').addEventListener('click', function() {
            document.getElementById('news-modal').classList.add('hidden');
        });

        // Обработка загрузки медиа
        document.getElementById('media').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const mediaName = document.getElementById('media-name');
                const uploadPrompt = document.getElementById('upload-prompt');
                const mediaPreview = document.getElementById('media-preview');

                mediaName.textContent = file.name;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        mediaPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg" alt="Загруженное медиа">`;
                        mediaPreview.classList.remove('hidden');
                        uploadPrompt.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    mediaPreview.innerHTML = `
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    `;
                    mediaPreview.classList.remove('hidden');
                    uploadPrompt.classList.add('hidden');
                }
            }
        });

        // Функция для загрузки новостей
        async function loadNews() {
            const newsFeed = document.getElementById('news-feed');
            try {
                // Имитация задержки загрузки
                await new Promise(resolve => setTimeout(resolve, 1000));

                // Загрузка данных с сервера
                const response = await fetch('/news/lazy'); // Измененный URL
                const data = await response.json();

                // Очистка скелетонов
                newsFeed.innerHTML = '';

                // Добавление реальных новостей
                data.forEach(item => {
                    const newsItem = document.createElement('div');
                    newsItem.className = 'bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4 transform transition-all duration-300 hover:scale-105 hover:shadow-lg';
                    let mediaContent = '';

                    if (item.media_path) {
                        if (item.media_path.endsWith('.mp4') || item.media_path.endsWith('.mov')) {
                            // Отображаем видео сразу
                            mediaContent = `
                                <video controls class="mt-2 rounded-lg w-full" loading="lazy">
                                    <source src="${item.media_path}" type="video/mp4">
                                </video>
                            `;
                        } else {
                            // Отображаем обычное изображение
                            mediaContent = `<img src="${item.media_path}" alt="Изображение" class="mt-2 rounded-lg w-full" loading="lazy" style="object-fit: cover; height: 200px;">`;
                        }
                    }

                    newsItem.innerHTML = `
                        <div class="flex justify-between items-center mb-2">
                            <button class="text-gray-500 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <h2 class="text-xl font-semibold mb-2 dark:text-white">${item.title}</h2>
                        <p class="mb-4 text-gray-600 dark:text-gray-300">${item.content}</p>
                        ${mediaContent}
                        <div class="flex justify-between items-center mt-4">
                            <small class="text-gray-500 dark:text-gray-400">Опубликовано ${new Date(item.created_at).toLocaleString()}</small>
                            <div class="flex space-x-4">
                                <button class="text-gray-500 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                                <button class="text-gray-500 hover:text-green-500 dark:hover:text-green-400 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </button>
                                <button class="text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L13.586 11H4a1 1 0 110-2h9.586l-4.293-4.293a1 1 0 010-1.414z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                    newsFeed.appendChild(newsItem);
                });
            } catch (error) {
                console.error('Ошибка загрузки новостей:', error);
            }
        }

        // Загрузка новостей при загрузке страницы
        document.addEventListener('DOMContentLoaded', loadNews);
    </script>

    <style>
        #news-modal {
    z-index: 40;
}

#create-news-button {
    z-index: 50;
}
    </style>
@endsection
