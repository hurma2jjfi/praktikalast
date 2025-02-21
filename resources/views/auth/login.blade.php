@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Вход</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="login" class="block text-gray-700">Логин</label>
                <input type="text" name="login" id="login" class="w-full p-2 border rounded @error('login') border-red-500 @enderror" value="{{ old('login') }}" required>
                @error('login')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Пароль</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            @if (session('error'))
                <p class="text-red-500 text-xs italic">{{ session('error') }}</p>
            @endif
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">Войти</button>
        </form>
    </div>
@endsection
