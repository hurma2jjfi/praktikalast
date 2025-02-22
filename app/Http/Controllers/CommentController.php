<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, News $news)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $news->id,
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Комментарий успешно добавлен.');
    }
}