@extends('layouts.app')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div id="app">
        <chat-component
            :user="{{ json_encode($user) }}"
            :initial-messages="{{ json_encode($messages) }}"
            :current-user="{{ json_encode(Auth::user()) }}"
            :chat-id="{{ $chat->id }}"
        ></chat-component>
    </div>
@endsection