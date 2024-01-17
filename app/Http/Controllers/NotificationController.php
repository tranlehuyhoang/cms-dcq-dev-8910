<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserHasNotification;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class NotificationController extends Controller
{

	public function index()
	{
		$perPage = 1; // Số lượng thông báo hiển thị trên mỗi trang
		$notifications = Notification::with('user', 'userHasNotification.user')
			->orderBy('created_at', 'desc')
			->paginate($perPage);

		foreach ($notifications as $notification) {
			foreach ($notification['userHasNotification'] as $userHasNotification) {

				// dd($userHasNotification->user);
				$user = User::find($userHasNotification->user->id);

				$avatarPath = '/assets/images/users/avatar-basic.jpg';
				$avatar = $user->getFirstMedia('avatar');
				$hasAvatar = $user->hasMedia('avatar');

				if ($hasAvatar) {
					$avatarPath = $avatar->getUrl();
				}

				$userHasNotification->userAvatar = $avatarPath;
			}
			$user = User::find($notification->sender_id);

			$avatarPath = '/assets/images/users/avatar-basic.jpg';
			$avatar = $user->getFirstMedia('avatar');
			$hasAvatar = $user->hasMedia('avatar');

			if ($hasAvatar) {
				$avatarPath = $avatar->getUrl();
			}

			$createdDate = $notification->created_at->setTimezone('Asia/Ho_Chi_Minh');
			$notification->diffForHumansInVietnam = $createdDate->diffForHumans();
			$notification->senderAvatar = $avatarPath;
		}

		return view('notifications.index', compact('notifications'));
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
