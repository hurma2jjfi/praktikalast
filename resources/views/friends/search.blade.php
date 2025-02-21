@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Поиск друзей</h1>
<form method="GET" action="{{ route('friends.search') }}" class="mb-4">
    <input type="text" name="search" placeholder="Введите логин" class="w-full p-2 border rounded" required>
    <button type="submit" class="bg-blue-600 text-white p-2 rounded mt-2">Искать</button>
</form>

@if($users->isEmpty())
    <p>Пользователи не найдены.</p>
@else
    @foreach($users as $user)
        <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center">
            @if($user->userInfo && $user->userInfo->avatar)
                <img src="{{ asset('storage/' . $user->userInfo->avatar) }}" alt="Аватар" class="w-12 h-12 rounded-full mr-4">
            @else
                <img src="https://via.placeholder.com/50" alt="Нет аватара" class="w-12 h-12 rounded-full mr-4">
            @endif
            <div>
                <p>{{ $user->login }}</p>
                <form method="POST" action="{{ route('friends.add', $user) }}">
                    @csrf
                    <button type="submit" class="text-blue-600">Добавить в друзья</button>
                </form>
            </div>
        </div>
    @endforeach
@endif

@if (session('error'))
    <div class="bg-red-500 text-white p-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="bg-green-500 text-white p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@endsection
