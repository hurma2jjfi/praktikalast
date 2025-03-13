<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    
        public function showAdmin() {
    
            $userCount = $this->getUsersCount();
            $postCount = $this->getPostsCount();
            $likeCount = $this->getLikesCount();
            $categories = $this->getCategories();

            $users = Cache::remember('admin_users_list', 60, function () {
                return User::with('userInfo')->get();
            });
    
            $userInfos = Cache::remember('admin_user_infos_list', 60, function () {
                return UserInfo::all();
            });
    
            return view('admin.admin', compact('userCount', 'postCount', 'likeCount', 'users', 'userInfos', 'categories'));
        }
    
        public function getUsersCount()  {
            return Cache::remember('userCount', 60, function() {
                return User::count();
            });
    
        }
    
        public function getPostsCount() {
            return Cache::remember('postCount', 60, function() {
                return Post::count();
            });
    
        }
    
        public function getLikesCount() {
            return Cache::remember('likeCount', 60, function() {
                return Like::count();
            });
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
    
            // Очищаем кэш списка пользователей
            Cache::forget('admin_users_list');
    
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
    
            // Очищаем кэш списка пользователей
            Cache::forget('admin_users_list');
    
            return redirect()->route('admin.admin')->with('success', 'Пользователь успешно разблокирован');
        }


        public function getCategories() {
            return Cache::remember('admin_categories_list', 60, function () {
             return Category::all();
            });
        }
}
