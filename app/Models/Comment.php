<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /**
     * Поля, которые можно массово назначать.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',   // ID пользователя, оставившего комментарий
        'post_id',  // ID поста, к которому относится комментарий
        'content',   // Текст комментария
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
     * Связь с моделью Post.
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}