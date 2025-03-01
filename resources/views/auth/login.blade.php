@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Вход</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5 relative">
                <input
                    type="text"
                    name="login"
                    id="login"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('login') border-red-500 @enderror"
                    value="{{ old('login') }}"
                    required
                >
                <label for="login" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Логин</label>
                @error('login')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5 relative">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror"
                    required
                >
                <label for="password" class="block text-sm font-medium text-gray-700 absolute top-3 left-3 transition-all duration-200">Пароль</label>
                @error('password')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            @if (session('error'))
                <p class="text-red-500 text-xs italic mb-4">{{ session('error') }}</p>
            @endif
            <button
                type="submit"
                class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
            >
                Войти
            </button>
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



    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('.text-red-500')) {
            const inputs = document.querySelectorAll('.relative input');
            inputs.forEach(input => {
                input.classList.add('border-red-500');
            });
        }
    });


</script>
