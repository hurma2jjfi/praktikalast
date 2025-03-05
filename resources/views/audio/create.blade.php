@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Загрузить музыку</h1>
        
        <form action="{{ route('audio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Название</label>
                <input type="text" name="title" id="title" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="artist" class="block text-gray-700">Исполнитель</label>
                <input type="text" name="artist" id="artist" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="audio_file" class="block text-gray-700">Аудиофайл</label>
                <input type="file" name="audio_file" id="audio_file" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="cover_image" class="block text-gray-700">Обложка</label>
                <input type="file" name="cover_image" id="cover_image" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Описание</label>
                <textarea name="description" id="description" class="form-textarea mt-1 block w-full"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Загрузить</button>
        </form>
    </div>
@endsection
