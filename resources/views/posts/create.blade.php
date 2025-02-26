@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Создать пост</h2>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-gray-700">Текст поста</label>
                <textarea name="content" id="content" class="w-full p-2 border rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Изображение</label>
                <input type="file" name="image" id="image" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="video" class="block text-gray-700">Видео</label>
                <input type="file" name="video" id="video" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Категория</label>
                <select name="category_id" id="category_id" class="w-full p-2 border rounded" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Опубликовать</button>
        </form>
    </div>
@endsection
