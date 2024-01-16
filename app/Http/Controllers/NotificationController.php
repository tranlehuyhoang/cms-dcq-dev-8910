<?php

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function index()
	{
		// Lấy 3 thông báo mới nhất và join với bảng người dùng
		$notifications = Notification::orderBy('created_at', 'desc')
			->take(3)
			->join('users', 'notifications.user_id', '=', 'users.id')
			->select('notifications.content', 'users.name')
			->get();

		return view('notifications.index', compact('notifications'));
	}
}
