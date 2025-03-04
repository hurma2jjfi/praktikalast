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
                <img src="{{ asset('storage/' . auth()->user()->userInfo->avatar) }}" alt="Аватар" class="w-32 h-32 rounded-full mb-2" id="avatar-preview">
            @else
                <img src="https://via.placeholder.com/128" alt="Аватар" class="w-32 h-32 rounded-full mb-2" id="avatar-preview">
            @endif

            <!-- Кнопка выбора файла -->
            <div class="relative w-32 h-10">
                <input type="file" name="avatar" id="avatar" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer">
                <label for="avatar" class="w-full h-full flex items-center justify-center border-2 border-dashed border-blue-400 text-gray-700 rounded-lg hover:border-purple-500 hover:text-purple-500 transition-all duration-300">
                    Выбрать файл
                </label>
            </div>
            @error('avatar')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Поля для смены пароля --}}
        <div class="mb-4">
            <label for="old_password" class="block text-gray-700">Старый пароль</label>
            <input type="password" name="old_password" id="old_password" class="w-full p-2 border rounded @error('old_password') border-red-500 @enderror">
            @error('old_password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Новый пароль</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">Сохранить</button>
    </form>

    {{-- Отображение ошибок --}}
    @if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

</div>

<script>
    document.getElementById('avatar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection