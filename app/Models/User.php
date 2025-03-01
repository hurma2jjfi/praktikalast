<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UserActivityStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use UserActivityStatus;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'user1_id')->orWhere('user2_id', $this->id);
    }

    public function acceptedFriends()
    {
        return $this->friends()->where('status', 'Принято');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }




}
