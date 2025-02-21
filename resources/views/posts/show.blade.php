@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <h3 class="font-bold">{{ $post->user->login }}</h3>
        <p>{{ $post->content }}</p>
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="mt-2">
        @endif
    </div>

    <h2 class="text-2xl font-bold mb-4">Комментарии</h2>
    <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-4">
        @csrf
        <textarea name="content" placeholder="Оставьте комментарий" class="w-full p-2 border rounded" required></textarea>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded mt-2">Отправить</button>
    </form>

    @foreach($post->comments as $comment)
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <p><strong>{{ $comment->user->login }}:</strong> {{ $comment->content }}</p>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
            @can('delete', $comment)
                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Удалить</button>
                </form>
            @endcan
        </div>
    @endforeach
@endsection