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

		// Sửa tất cả các hàng trong bảng UserHasNotification và đặt mark_read là 1
		UserHasNotification::query()
			->where('user_id', $user->id)
			->update(['mark_read' => 1]);
		// dd($request);

		return response()->json(['message' => 'Successfully marked as read']);
	}
}
