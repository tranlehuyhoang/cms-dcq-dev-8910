<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasNotification extends Model
{
	protected $table = 'user_has_notification';
	protected $fillable = ['notification_id', 'user_id', 'mark_read'];

	// Không quản lý trường updated_at và created_at
	public $timestamps = false;

	// Các mối quan hệ
	public function notification()
	{
		return $this->belongsTo(Notification::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
