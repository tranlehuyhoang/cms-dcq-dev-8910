<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	const LIMIT = 3;
	protected $table = 'notifications';
	protected $fillable = ['content', 'sender_id', 'created_at', 'updated_at'];

	// Các mối quan hệ
	public function user()
	{
		return $this->belongsTo(User::class, 'sender_id');
	}
	public function userHasNotification()
	{
		return $this->hasMany(UserHasNotification::class, 'notification_id');
	}
}
