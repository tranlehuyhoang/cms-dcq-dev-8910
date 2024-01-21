<?php

namespace App\Http\Controllers;

use App\Models\UserHasNotification;
use Illuminate\Http\Request;

class UserHasNotificationController extends Controller
{
	public function markAsRead(Request $request)
	{
		// Sửa tất cả các hàng trong bảng UserHasNotification và đặt mark_read là 1
		UserHasNotification::query()->update(['mark_read' => 1]);
		// dd($request);

		return response()->json(['message' => 'Successfully marked as read']);
	}
}
