<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Like;

class Post extends Model
{


    
    /**
     * Поля, которые можно массово назначать.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',       // ID пользователя, создавшего пост
        'category_id',   // ID категории, к которой относится пост
        'content',       // Текст поста
        'image',         // Путь к изображению (если есть)
        'video',         // Ссылка на видео (если есть)
    ];

    /**
     * Поля, которые должны быть скрыты при сериализации.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',    // Скрываем поле "updated_at" при сериализации
    ];

    /**
     * Связь с моделью User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с моделью Category.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с моделью Comment (если в проекте есть комментарии).
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Получить URL изображения поста.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Получить превью видео (если видео есть).
     *
     * @return string|null
     */
    public function getVideoPreviewAttribute(): ?string
    {
        if ($this->video) {
            // Пример для YouTube: извлечение ID видео и создание ссылки на превью
            if (str_contains($this->video, 'youtube.com')) {
                $videoId = substr(parse_url($this->video, PHP_URL_QUERY), 2);
                return "https://img.youtube.com/vi/{$videoId}/0.jpg";
            }
        }
        return null;
    }

    public function likes(): HasMany
{
    return $this->hasMany(Like::class);
}

public function isLikedBy(User $user): bool
{
    return $this->likes()->where('user_id', $user->id)->exists();
}

public function likesCount(): int
{
    return $this->likes()->count();
}
}