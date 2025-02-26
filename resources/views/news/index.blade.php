@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <a style="text-decoration: underline" href="{{ route('news.upload') }}">Добавить новость</a>

        <h1 class="text-3xl font-bold mb-4">Лента новостей</h1>

        @if($news->isEmpty())
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <p class="text-gray-600">Нет новостей.</p>
            </div>
        @else
            @foreach($news as $item)
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $item->title }}</h2>
                    <p class="mb-4">{{ $item->content }}</p>

                    @if($item->media_path)
                        @if(Str::endsWith($item->media_path, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/' . $item->media_path) }}" alt="Изображение" class="mt-2 rounded-lg">
                        @elseif(Str::endsWith($item->media_path, ['mp4', 'mov']))
                            <video controls class="mt-2 rounded-lg w-full">
                                <source src="{{ asset('storage/' . $item->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @endif

                    <div class="flex__timestamp mt-2">
                    <small class="text-gray-500">Опубликовано {{ $item->created_at->diffForHumans() }}</small></div>
                </div>
            @endforeach
        @endif
    </div>

    <style>
        .flex__timestamp {
            display: flex;
            justify-content: end;
        }
    </style>
@endsection