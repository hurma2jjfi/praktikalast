@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Создать пост</h2>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-gray-700 mb-2">Текст поста</label>
                <textarea name="content" id="content" class="w-full p-2 border border-dashed border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" rows="4" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 mb-2">Изображение</label>
                <div class="relative border border-dashed border-gray-400 rounded-lg p-4 text-center" id="imageContainer">
                    <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="readURL(this);">
                    <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-gray-600">Загрузите изображение</span>
                </div>
                <div id="imagePreview" class="mt-4"></div>
            </div>
            <div class="mb-4">
                <label for="video" class="block text-gray-700 mb-2">Видео</label>
                <div class="relative border border-dashed border-gray-400 rounded-lg p-4 text-center">
                    <input type="file" name="video" id="video" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-gray-600">Загрузите видео</span>
                </div>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 mb-2">Категория</label>
                <div class="relative">
                    <div class="custom-dropdown" id="customDropdown">
                        <div class="dropdown-header" onclick="toggleDropdown()">
                            <span id="selectedCategory">Выберите категорию</span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="dropdown-options" id="dropdownOptions">
                            @foreach($categories as $category)
                                <div class="dropdown-option" data-value="{{ $category->id }}" onclick="selectOption(this)">
                                    {{ $category->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="category_id" id="category_id" value="">
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition duration-200">Опубликовать</button>
        </form>
    </div>
@endsection

<style>
    .custom-dropdown {
        position: relative;
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background-color: white;
        cursor: pointer;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown-header {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown-options {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        max-height: 0;
        overflow: hidden;
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        opacity: 0;
        z-index: 10;
        padding: 0.5rem 0;
    }

    .dropdown-options.open {
        max-height: 200px;
        opacity: 1;
        overflow-y: auto;
    }

    .dropdown-option {
        padding: 0.5rem 1rem;
        transition: background-color 0.2s;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
    }

    .dropdown-option:last-child {
        border-bottom: none;
    }

    .dropdown-option:hover {
        background-color: #f3f4f6;
    }

    .dropdown-option::before {
        content: "";
        display: inline-block;
        width: 4px;
        height: 4px;
        background-color: #66d9ef; /* Цвет для Telegram */
        border-radius: 50%;
        margin-right: 0.5rem;
    }

    /* Для разных цветов */
    .dropdown-option:nth-child(1)::before {
        background-color: #66d9ef; /* Telegram */
        
    }
    .dropdown-option:nth-child(2)::before {
        background-color: #8e24aa; /* Фиолетовый */
    }
    .dropdown-option:nth-child(3)::before {
        background-color: #4caf50; /* Зеленый */
    }
    .dropdown-option:nth-child(4)::before {
        background-color: #03a9f4; /* Синий */
    }
    .dropdown-option:nth-child(5)::before {
        background-color: #ff9800; /* Оранжевый */
    }

    /* Кастомный скроллбар */
    .dropdown-options::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-options::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .dropdown-options::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .dropdown-options::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    function toggleDropdown() {
        const dropdownOptions = document.getElementById('dropdownOptions');
        const dropdownArrow = document.getElementById('dropdownArrow');
        dropdownOptions.classList.toggle('open');
        dropdownArrow.classList.toggle('rotate-180');
    }

    function selectOption(option) {
        const selectedCategory = document.getElementById('selectedCategory');
        const categoryIdInput = document.getElementById('category_id');
        selectedCategory.textContent = option.textContent;
        categoryIdInput.value = option.getAttribute('data-value');
        toggleDropdown();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" width="100%" height="auto">';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
