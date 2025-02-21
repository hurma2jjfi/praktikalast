<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{



    public function show()
{
    $user = Auth::user(); 
    ////Посты снизу 
    $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

    return view('profile.show', compact('user', 'posts')); 
}



    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    // Валидация данных
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|regex:/^[а-яА-ЯёЁ\s-]+$/u',
        'last_name' => 'required|regex:/^[а-яА-ЯёЁ\s-]+$/u',
        'login' => 'required|unique:users,login,' . $user->id . '|regex:/^[a-zA-Zа-яА-ЯёЁ0-9_-]+$/u',
        'email' => 'required|email|unique:users,email,' . $user->id, // Добавлена валидация email
        'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Обновление логина и email пользователя
    $user->login = $request->login;
    $user->email = $request->email; // Добавлено обновление email

    // Попробуем сохранить изменения
    try {
        $user->save();
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Ошибка при обновлении данных пользователя: ' . $e->getMessage()])->withInput();
    }

    // Поиск или создание UserInfo
    $userInfo = UserInfo::firstOrNew(['user_id' => $user->id]);
    $userInfo->first_name = $request->first_name;
    $userInfo->last_name = $request->last_name;

    // Обновление аватара, если он загружен
    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
    
        // Сохранение файла в storage/app/public/avatars
        $path = $avatar->storeAs('public/avatars', $filename);

        // Сохранение пути в базе данных в формате avatars/путь
        $userInfo->avatar = 'avatars/' . $filename; 
    }
    

    // Попробуем сохранить UserInfo
    try {
        $userInfo->save();
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Ошибка при обновлении информации о пользователе: ' . $e->getMessage()])->withInput();
    }

    // Редирект на страницу редактирования профиля с сообщением об успехе
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

}
