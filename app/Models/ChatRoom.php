<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;


class ChatRoom extends Model {
    public static $rules = [
    ];

    public $table = 'chat_room';

    public $fillable = [
        'user_id',
    ];
}
