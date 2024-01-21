<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia {
    use HasApiTokens, HasFactory, Notifiable;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'country',
        'facebook',
        'point_accumulated',
        'expertise_coefficient',
        'allowance'
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
        'password' => 'hashed',
    ];

    const ADMIN = 'admin';
    const MANAGER = 'manager';

    public function userRole() {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function getLatestChat($chatId, $user_id)
    {
        if ($chatId != null) {

            return ChatMission::where('chat_id', $chatId)
            ->orderBy('id', 'desc')
            ->first();
        }
        return null;
    }
    public function getChatRoom($userId, $authUserId)
    {
       return ChatRoom::whereJsonContains('user_id', [$authUserId, $userId])->first();
    }

}
