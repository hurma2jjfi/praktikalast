@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Редактировать профиль</h2>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="first_name" class="block text-gray-700">Имя</label>
                <input type="text" name="first_name" id="first_name" value="{{ auth()->user()->userInfo->first_name ?? '' }}" class="w-full p-2 border rounded @error('first_name') border-red-500 @enderror" required>
                @error('first_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-gray-700">Фамилия</label>
                <input type="text" name="last_name" id="last_name" value="{{ auth()->user()->userInfo->last_name ?? '' }}" class="w-full p-2 border rounded @error('last_name') border-red-500 @enderror" required>
                @error('last_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="login" class="block text-gray-700">Логин</label>
                <input type="text" name="login" id="login" value="{{ auth()->user()->login }}" class="w-full p-2 border rounded @error('login') border-red-500 @enderror" required>
                @error('login')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="w-full p-2 border rounded @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="avatar" class="block text-gray-700">Аватар</label>
                @if (auth()->user()->userInfo && auth()->user()->userInfo->avatar)
                <img src="{{ asset('storage/' . auth()->user()->userInfo->avatar) }}" alt="Аватар" class="w-32 h-32 rounded-full mb-2">
                @endif
                <input type="file" name="avatar" id="avatar" class="@error('avatar') border-red-500 @enderror">
                @error('avatar')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">Сохранить</button>
        </form>

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    </div>
@endsection
