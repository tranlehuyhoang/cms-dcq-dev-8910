<?php

namespace App\Http\Controllers;

use App\Models\UserHasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasNotificationController extends Controller
{
	public function markAsRead(Request $request)
	{
		$user = Auth::user();

		// Cập nhật tất cả các hàng trong bảng UserHasNotification có user_id = $user->id
		UserHasNotification::where('user_id', $user->id)->update(['mark_read' => 1]);

		return response()->json(['message' => 'Successfully marked as read']);
	}
}
