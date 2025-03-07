<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo; // Импортируйте модель UserInfo
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'login' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
        'avatar' => 'nullable|image|max:2048', // Валидация для аватара
    ]);

    // Создаем пользователя
    $user = User::create([
        'login' => $validated['login'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // Обработка загрузки аватара
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Сохранение файла в папку storage/app/public/avatars

        // Создаем запись UserInfo и связываем с пользователем
        UserInfo::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'avatar' => $avatarPath, // Сохраняем путь к аватару
        ]);
    } else {
        // Создаем запись UserInfo без аватара
        UserInfo::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
        ]);
    }

    Auth::login($user);
    return redirect()->route('profile');
}



public function login(Request $request)
{
    // Валидация входящих данных
    $validated = $request->validate([
        'login' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt(['login' => $validated['login'], 'password' => $validated['password']])) {

        $user = Auth::user();

        if($user->is_banned) {
            Auth::logout();
            return redirect()->back()->with('message', 'Ваш аккаунт заблокирован');

        }


        if ($user->is_admin) {

            return redirect()->route('admin.admin');
        } else {

            return redirect()->route('news.index');
        }
    }

    return back()->withErrors([
        'login' => 'Неверное имя пользователя или пароль.',
    ]);
}

    public function logout()
{
    Auth::logout();
    return redirect('/')->with('success', 'Вы вышли из аккаунта!');
}


}
