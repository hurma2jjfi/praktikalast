<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Audio;
use Illuminate\Support\Facades\Storage;
use getID3;

class AudioController extends Controller
{

    public function index(Request $request): View
    {
        // Получаем параметр сортировки из запроса
        $sortBy = $request->get('sort_by', 'created_at'); // По умолчанию сортируем по дате создания
        $sortOrder = $request->get('sort_order', 'desc'); // По умолчанию сортируем по убыванию

        // Возможные поля для сортировки
        $allowedSortColumns = ['title', 'artist', 'duration', 'created_at'];

        // Проверяем, что запрошенное поле для сортировки допустимо
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'created_at';
        }

        // Получаем аудиозаписи с учетом сортировки
        $audios = Audio::orderBy($sortBy, $sortOrder)->get();

        return view('audio.index', compact('audios', 'sortBy', 'sortOrder'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'artist' => 'nullable|string|max:255',
        'audio_file' => 'required|file|mimes:mp3,wav', // Ограничение на тип файла
        'cover_image' => 'nullable|image|mimes:jpg,jpeg,png', // Ограничение на тип изображения
        'description' => 'nullable|string',
    ]);

    $filePath = $request->file('audio_file')->store('audios', 'public'); // Сохраняем файл в папку 'audios'

    $coverPath = null;
    if ($request->hasFile('cover_image')) {
        echo "Обложка присутствует\n"; // Для отладки
        try {
            $coverPath = $request->file('cover_image')->store('covers', 'public'); // Сохраняем обложку в папку 'covers'
            echo "Обложка загружена: $coverPath\n"; // Для отладки
        } catch (\Exception $e) {
            echo "Ошибка при загрузке обложки: " . $e->getMessage() . "\n"; // Для отладки
        }
    } else {
        echo "Обложка не присутствует\n"; // Для отладки
    }

    $audio = Audio::create([
        'title' => $request->title,
        'artist' => $request->artist,
        'file_path' => $filePath,
        'cover_path' => $coverPath, // Сохраняем путь к обложке
        'duration' => $this->getAudioDuration($filePath), // Метод для получения длительности аудио
        'description' => $request->description,
    ]);

    echo "Обложка в БД: " . $audio->cover_path . "\n"; // Для отладки

    return redirect()->route('audio.index')->with('success', 'Аудио успешно загружено!');
}




public function show($id)
{
    $audio = Audio::findOrFail($id); // Находим аудио по ID
    return view('audio.show', compact('audio'));
}

public function destroy($id)
{
    $audio = Audio::findOrFail($id);
    Storage::disk('public')->delete($audio->file_path); // Удаляем файл с сервера
    if ($audio->cover_path) {
        Storage::disk('public')->delete($audio->cover_path); // Удаляем обложку
    }
    $audio->delete(); // Удаляем запись из базы данных

    return redirect()->route('audio.index')->with('success', 'Аудио успешно удалено!');
}


public function create()
{
    return view('audio.create');
}


public function getAudioDuration($filePath)
{
    $getID3 = new GetId3();
    $audio = $getID3->analyze(storage_path('app/public/' . $filePath));
    return $audio['playtime_seconds'];
}



}
