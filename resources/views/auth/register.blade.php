@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Регистрация</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4 relative">
                <input type="text" name="first_name" id="first_name" class="w-full p-3 border rounded @error('first_name') border-red-500 @enderror" value="{{ old('first_name') }}" required>
                <label for="first_name" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Имя</label>
                @error('first_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 relative">
                <input type="text" name="last_name" id="last_name" class="w-full p-3 border rounded @error('last_name') border-red-500 @enderror" value="{{ old('last_name') }}" required>
                <label for="last_name" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Фамилия</label>
                @error('last_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 relative">
                <input type="text" name="login" id="login" class="w-full p-3 border rounded @error('login') border-red-500 @enderror" value="{{ old('login') }}" required>
                <label for="login" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Логин</label>
                @error('login')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 relative">
                <input type="email" name="email" id="email" class="w-full p-3 border rounded @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                <label for="email" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Email</label>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 relative">
                <input type="password" name="password" id="password" class="w-full p-3 border rounded @error('password') border-red-500 @enderror" required>
                <label for="password" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Пароль</label>
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 relative">
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 border rounded" required>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Повторите пароль</label>
            </div>

            <!-- Поле для загрузки аватара -->
            <div class="mb-4 file-upload">
                <input type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png,.gif" class="hidden" @error('avatar') border-red-500 @enderror>
                <label for="avatar" class="block text-sm font-medium text-gray-700 cursor-pointer">Загрузить аватар</label>
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

<style>
    .relative input:focus + label, .relative input.has-value + label {
        top: -0.5rem;
        background-color: white;
        padding: 0 0.5rem;
        font-size: 0.8rem;
    }

    .relative label {
        pointer-events: none;
    }

    .file-upload {
        border: 1px dashed #ccc;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .file-upload label {
        cursor: pointer;
    }

    .relative input:focus {
    outline: none;
    border: 2px solid #3498db;
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.relative input');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });

            input.addEventListener('focus', function() {
                if (this.value.trim() === '') {
                    this.classList.add('has-value');
                }
            });

            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.remove('has-value');
                }
            });
        });
    });
</script>
