<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\UserInfo;

class AdminController extends Controller
{
    
    public function showAdmin() {

        $userCount = $this->getUsersCount();
        $postCount = $this->getPostsCount();
        $likeCount = $this->getLikesCount();
        $users = User::all();
        $userInfos = UserInfo::all();
        return view('admin.admin', compact('userCount', 'postCount', 'likeCount', 'users', 'userInfos'));
    }

    public function getUsersCount()  {
        return User::count();
    }

    public function getPostsCount() {
        return Post::count();
    }

    public function getLikesCount() {
        return Like::count();
    }

    public function getUsersList() {
        $users = User::all();
        return view('admin.admin', compact('users'));
    }

    public function getUserInfosList() {
        $userInfos = UserInfo::all();
        return view('admin.admin', compact('userInfos'));
    }
    

    public function addCategory(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.admin')->with('success', 'Категория успешно добавлена!');
    }

    public function banUser(Request $request, $id) {
        $user = User::find($id);

        if(!$user) {
            return redirect()->route('admin.admin')->with('error', 'Пользователь не найден');
        }

        $user->is_banned = true;
        $user->save();

        return redirect()->route('admin.admin')->with('success', 'Пользователь успешно заблокирован');
    }

    public function unbanUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.admin')->with('error', 'Пользователь не найден.');
        }

        $user->is_banned = false;
        $user->save();

        return redirect()->route('admin.admin')->with('success', 'Пользователь успешно разблокирован');
    }
    


}
