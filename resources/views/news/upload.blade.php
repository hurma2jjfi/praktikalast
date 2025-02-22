@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Добавить новость</h1>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data"> <!-- Добавлено enctype -->
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Заголовок</label>
            <input type="text" name="title" id="title" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="content" class="block text-gray-700">Содержимое</label>
            <textarea name="content" id="content" class="w-full p-2 border rounded" required></textarea>
        </div>

        <div class="mb-4">
            <label for="media" class="block text-gray-700">Медиа (изображение или видео)</label>
            <input type="file" name="media" id="media" class="w-full p-2 border rounded" accept=".jpg,.jpeg,.png,.gif,.mp4,.mov"> 
        </div>

        <button type="submit" class="bg-blue-600 text-white p-2 rounded">Добавить новость</button>
    </form>
</div>
@endsection
