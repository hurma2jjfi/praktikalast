<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{

    public function getLazy()
    {
        $news = News::latest()->get()->map(function ($item) {
            if ($item->media_path) {
                $item->media_path = asset('storage/' . $item->media_path);
            }
            return $item;
        });

        return response()->json($news);
    }

    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->get();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.upload');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'nullable|string|max:255',
        'content' => 'nullable|string',
        'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:20480',
    ]);

    $mediaPath = null; // Инициализация переменной для пути медиафайла

    // Сохранение файла мультимедиа, если он загружен
    if ($request->hasFile('media')) {
        // Проверка на наличие файла
        $file = $request->file('media');

        if ($file->isValid()) { // Проверка, что файл корректный
            // Сохранение файла в папку storage/app/public/media
            $path = $file->store('public/media');
            // Убираем "public/" из пути для хранения в БД
            $mediaPath = str_replace('public/', '', $path);
        } else {
            return back()->withErrors(['media' => 'Ошибка при загрузке файла.'])->withInput();
        }
    }

    // Создание новости с сохранением пути к медиафайлу
    News::create([
        'user_id' => Auth::id(),
        'title' => $validated['title'],
        'content' => $validated['content'],
        'media_path' => $mediaPath, // Используем переменную mediaPath
    ]);

    return redirect()->route('news.index')->with('success', 'Новость успешно добавлена.');
}


}
