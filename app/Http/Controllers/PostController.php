<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class PostController extends Controller
{


    public function create()
{
    // Получаем все категории (или только те, которые нужны)
    $categories = Category::all(); // Предполагается, что у вас есть модель Category

    return view('posts.create', compact('categories')); // Передаем категории в представление
}

    

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|url',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->category_id = $request->category_id;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $filename);
            $post->image = 'uploads/posts/' . $filename;
        }

        $post->video = $request->video;
        $post->save();

        return redirect()->route('profile')->with('success', 'Пост успешно создан.');
    }

    public function edit(Post $post)
    {
        
        // Проверяем, является ли текущий пользователь автором поста
        if (Auth::id() !== $post->user_id) {
            abort(403, 'У вас нет прав для редактирования этого поста.');
        }
        $categories = Category::all();
        return view('posts.edit', compact('post','categories'));
    }
    public function update(Request $request, Post $post)
    {
        // Проверяем, является ли текущий пользователь автором поста
        if (Auth::id() !== $post->user_id) {
            abort(403, 'У вас нет прав для редактирования этого поста.');
        }
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           
        ]);
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $filename);
            $post->image = 'uploads/posts/' . $filename;
        }
        $post->save();
        return redirect()->route('profile.show')->with('success', 'Пост успешно обновлен.');
    }


    public function destroy(Post $post)
    {
        // Проверяем, является ли текущий пользователь автором поста
        if (Auth::id() !== $post->user_id) {
            abort(403, 'У вас нет прав для удаления этого поста.');
        }
        $post->delete();
        return redirect()->route('profile.show')->with('success', 'Пост успешно удален.');
    }

}
