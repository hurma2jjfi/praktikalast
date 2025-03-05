@extends('layouts.app')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div id="app">
        <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
            <!-- Обложка и основная информация -->
            <div class="flex flex-col items-center text-center mb-8">
                @if($audio->cover_path)
                    <img src="{{ asset('storage/' . $audio->cover_path) }}" alt="Обложка" class="rounded-lg w-48 h-48 object-cover mb-4">
                @endif
                <h1 class="text-3xl font-bold text-gray-800">{{ $audio->title }}</h1>
                <p class="text-gray-600">{{ $audio->artist }}</p>
                <p class="text-gray-600">{{ $audio->duration }} сек.</p>
            </div>

            <!-- Описание трека -->
            <div class="mb-8">
                <p class="text-gray-700">{{ $audio->description }}</p>
            </div>

            <!-- Плеер -->
            <audio-player :audio-src="'{{ asset('storage/' . $audio->file_path) }}'"></audio-player>

            <!-- Кнопка удаления -->
            <form action="{{ route('audio.destroy', $audio->id) }}" method="POST" class="mt-6 text-center">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition duration-200">
                    Удалить трек
                </button>
            </form>
        </div>
    </div>
@endsection
