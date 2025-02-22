<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Friend;
use App\Models\User;

class ProfileController extends Controller
{



    public function show()
{
    $user = Auth::user();
     
    ////Посты снизу 
    $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

    $friendCount = $this->getCountFriends();

    return view('profile.show', compact('user', 'posts', 'friendCount')); 
}

public function getCountFriends()
{
    $user = Auth::user();

    // Получаем количество друзей
    $friendCount = Friend::where(function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->orWhere('friend_id', $user->id);
    })
    ->where('status', 'Принято') // Только принятые заявки
    ->count();

    return $friendCount; // Возвращаем только число
}



    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
{
    // Валидация данных профиля
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|regex:/^[а-яА-ЯёЁ\s-]+$/u',
        'last_name' => 'required|regex:/^[а-яА-ЯёЁ\s-]+$/u',
        'login' => 'required|unique:users,login,' . Auth::id() . '|regex:/^[a-zA-Zа-яА-ЯёЁ0-9_-]+$/u',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Обновление данных пользователя
    $user = Auth::user();
    $user->login = $request->login;
    $user->email = $request->email;

    // Проверка на старый пароль и обновление его, если введен новый пароль
    if ($request->filled('old_password')) {
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Неверный старый пароль.']);
        }

        // Валидация нового пароля
        $request->validate([
            'password' => 'required|confirmed|min:8', // Минимальная длина пароля 8 символов
        ]);

        // Обновление пароля пользователя
        $user->password = Hash::make($request->password);
    }

    // Сохранение изменений пользователя
    $user->save();

    // Обновление информации о пользователе (если необходимо)
    $userInfo = UserInfo::firstOrNew(['user_id' => $user->id]);
    $userInfo->first_name = $request->first_name;
    $userInfo->last_name = $request->last_name;

    // Обновление аватара, если он загружен
    if ($request->hasFile('avatar')) {
        if ($request->file('avatar')->isValid()) {
            $path = $request->file('avatar')->store('public/avatars');
            $userInfo->avatar = str_replace('public/', '', $path); 
        }
    }

    // Сохранение информации о пользователе
    $userInfo->save();

    return redirect()->route('profile.edit')->with('success', 'Профиль успешно обновлён.');
}






    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Неверный старый пароль.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Пароль успешно обновлен.');
    }


    public function destroy()
    {
        // Получаем текущего пользователя
        $user = Auth::user();

        // Удаляем пользователя
        $user->delete();

        // Выход из системы после удаления аккаунта
        Auth::logout();

        // Перенаправляем на страницу входа с сообщением об успехе
        return redirect()->route('login')->with('success', 'Ваш аккаунт был успешно удален.');
    }


    public function showAnother(User $user)
{
    // Получаем количество друзей
    $friendCount = Friend::where(function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->orWhere('friend_id', $user->id);
    })
    ->where('status', 'Принято') // Только принятые заявки
    ->count();

    

    // Получаем посты пользователя
    $posts = $user->posts()->latest()->get();

    return view('profile.another', compact('user', 'friendCount', 'posts'));
}
}
