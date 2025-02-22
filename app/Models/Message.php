<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'user_id', 'content', 'read_at'];

    // Добавьте это свойство
    protected $dates = [
        'created_at',
        'updated_at',
        'read_at', 
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
