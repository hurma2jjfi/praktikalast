<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Поставить или убрать лайк
    public function toggleLike(Post $post)
    {
        $user = Auth::user();

        // Проверяем, лайкнул ли пользователь пост
        $like = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if ($like) {
            // Если лайк уже есть, удаляем его
            $like->delete();
            $liked = false;
        } else {
            // Если лайка нет, создаем его
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        // Возвращаем JSON-ответ
        return response()->json([
            'liked' => $liked,
            'likesCount' => $post->likes()->count(),
        ]);
    }
}