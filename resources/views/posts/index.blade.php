@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Новостная лента</h1>
    <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white p-2 rounded mb-4 inline-block">Создать пост</a>
    @foreach($posts as $post)
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <h3 class="font-bold">{{ $post->user->login }}</h3>
            <p>{{ $post->content }}</p>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="mt-2">
            @endif
            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 mt-2 inline-block">Комментарии</a>
        </div>
    @endforeach
@endsection