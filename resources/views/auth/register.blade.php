@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Регистрация</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="first_name" class="block text-gray-700">Имя</label>
                <input type="text" name="first_name" id="first_name" class="w-full p-2 border rounded @error('first_name') border-red-500 @enderror" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-gray-700">Фамилия</label>
                <input type="text" name="last_name" id="last_name" class="w-full p-2 border rounded @error('last_name') border-red-500 @enderror" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="login" class="block text-gray-700">Логин</label>
                <input type="text" name="login" id="login" class="w-full p-2 border rounded @error('login') border-red-500 @enderror" value="{{ old('login') }}" required>
                @error('login')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border rounded @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                @error('email')
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

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Повторите пароль</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded" required>
            </div>

            <!-- Поле для загрузки аватара -->
            <div class="mb-4">
                <label for="avatar" class="block text-gray-700">Аватар</label>
                <input type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png,.gif" class="@error('avatar') border-red-500 @enderror">
                @error('avatar')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Согласие на обработку персональных данных -->
            <div class="mb-4">
                <label class="block text-gray-700">
                    <input type="checkbox" name="personal_data_agreement" id="personal_data_agreement" required>
                    Я даю согласие на обработку своих персональных данных в соответствии с <a href="#" class="underline" target="_blank">Политикой конфиденциальности</a>

                </label>
                @error('personal_data_agreement')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">Зарегистрироваться</button>
        </form>
    </div>
@endsection
