@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Новости</h1>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <p>Здесь будут отображаться последние новости. Следите за обновлениями!</p>
            
            <!-- Пример списка новостей -->
            <ul class="mt-4">
                <li class="border-b py-2">
                    <strong>Заголовок новости 1</strong>
                    <p>Краткое описание новости 1...</p>
                </li>
                <li class="border-b py-2">
                    <strong>Заголовок новости 2</strong>
                    <p>Краткое описание новости 2...</p>
                </li>
                <li class="border-b py-2">
                    <strong>Заголовок новости 3</strong>
                    <p>Краткое описание новости 3...</p>
                </li>
            </ul>
        </div>
    </div>
@endsection
