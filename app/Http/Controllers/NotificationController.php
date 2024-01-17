<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserHasNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

	public function index()
	{
		$data['notifications'] = Notification::with('user', 'userHasNotification.user')
			->orderBy('created_at', 'desc')
			->get();
		// dd($data['notifications']);
		// $data['html'] = view('notifications.render_all_notification', ['notifications' => $data['notifications']])->render();

		return view('notifications.index', $data);
	}
	public function getNewNotification()
	{
		$data['notifications'] = Notification::orderBy('created_at', 'desc')
			->take(Notification::LIMIT)
			->with('user')
			->with('userHasNotification')
			->get();

		foreach ($data['notifications'] as $notificationId => $notification) {
			$createdDate = \Carbon\Carbon::parse($notification->created_at)->setTimezone('Asia/Ho_Chi_Minh');
			$notification->diffForHumansInVietnam = $createdDate->diffForHumans();
			// Các xử lý dữ liệu khác trong vòng lặp

			// Xử lý avatar
			$user = $notification->user;
			$avatar = $user->getFirstMedia('avatar');
			$hasAvatar = $user->hasMedia('avatar');

			if ($hasAvatar) {
				$data['notifications'][$notificationId]['avatar'] = $avatar->getUrl();
			} else {
				$data['notifications'][$notificationId]['avatar'] = '/assets/images/users/avatar-basic.jpg';
				// Xử lý tương ứng tại đây
			}
		}
		$html = view('notifications.render_new_notification', ['notifications' => $data['notifications']])->render();
		// dd($html);

		return response()->json(['html' => $html], 200);
	}
}
