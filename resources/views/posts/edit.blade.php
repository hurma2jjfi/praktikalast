@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Редактировать пост</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Поле для категории -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Категория</label>
                <select name="category_id" id="category_id" class="w-full p-2 border rounded" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Поле для текста поста -->
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-bold mb-2">Текст поста</label>
                <textarea name="content" id="content" rows="5" class="w-full p-2 border rounded" required>{{ $post->content }}</textarea>
            </div>

            <!-- Поле для изображения -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Изображение</label>
                <input type="file" name="image" id="image" class="w-full p-2 border rounded">
                @if ($post->image)
                    <img src="{{ asset($post->image) }}" alt="Текущее изображение" class="mt-2 w-32 h-32 rounded">
                @endif
            </div>

            <!-- Кнопка обновления -->
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Обновить пост</button>
        </form>
    </div>
@endsection
