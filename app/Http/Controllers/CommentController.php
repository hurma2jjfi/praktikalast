<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post; // Используем модель Post вместо News
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post) // Используем Post вместо News
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id, // Используем ID поста
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Комментарий успешно добавлен.');
    }


    public function destroy(Comment $comment)
    {
        // Проверяем, является ли текущий пользователь автором комментария
        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'У вас нет прав на удаление этого комментария.');
        }

        $comment->delete();

        return back()->with('success', 'Комментарий успешно удален.');
    }



}