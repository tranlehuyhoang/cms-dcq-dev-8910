<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserHasNotification;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

	public function index()
	{
		$user = Auth::user();
		$data['role']  = Roles::where('id', $user->role_id)->value('code');
		$data['arRoles'] = Roles::whereIn('code', [User::ADMIN, User::MANAGER])->get()->pluck('name', 'id')->toArray();
		// dd($data['role']);
		if ($data['role'] == 'admin') {
			$perPage = 3; // Số lượng thông báo hiển thị trên mỗi trang
			$notifications = Notification::with('user', 'userHasNotification.user')
				->whereHas('userHasNotification.user', function ($query) {
					$query->where('user_id', '>', 0);
				})
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
		} else {

			return redirect('dashboard');
		}
	}
	public function create()
	{
		$user = Auth::user();

		$data['users'] = User::get();


		foreach ($data['users'] as $userData) {
			$avatarPath = '/assets/images/users/avatar-basic.jpg';
			$avatar = $userData->getFirstMedia('avatar');
			$hasAvatar = $userData->hasMedia('avatar');

			if ($hasAvatar) {
				$avatarPath = $avatar->getUrl();
			}

			$userData->avatarPath = $avatarPath;
		}
		// dd($data['users']);

		return view('notifications.create', $data);
	}
	public function store(Request $request)
	{
		$user = Auth::user();
		$content = $request->input('content');
		$title = $request->input('title');
		dd($content);
		$notification = Notification::create([
			'sender_id' => $user->id,
			'content' => $content,
			'title' => $title
		]);

		$selectedUsers = $request->input('selected_users');

		foreach ($selectedUsers as $selectedUser) {
			UserHasNotification::create([
				'notification_id' => $notification->id,
				'user_id' => $selectedUser,
				'mark_read' => 0
			]);
		}
		return redirect()->route('notifications');
		// Additional code if needed

		// Return a response or redirect
	}
	public function getNewNotification()
	{
		$user = Auth::user();

		$data['notifications'] = Notification::orderBy('created_at', 'desc')
			->take(Notification::LIMIT)
			->with('user')
			->with('userHasNotification.user')
			->whereHas('userHasNotification', function ($query) use ($user) {
				$query->where('user_id', $user->id);
			})
			->get();

		foreach ($data['notifications'] as $notificationId => $notification) {
			$createdDate = \Carbon\Carbon::parse($notification->created_at)->setTimezone('Asia/Ho_Chi_Minh');
			$notification->diffForHumansInVietnam = $createdDate->diffForHumans();
			// Other data processing inside the loop

			// Process avatar
			$user = $notification->user;
			$avatar = $user->getFirstMedia('avatar');
			$hasAvatar = $user->hasMedia('avatar');

			if ($hasAvatar) {
				$data['notifications'][$notificationId]['avatar'] = $avatar->getUrl();
			} else {
				$data['notifications'][$notificationId]['avatar'] = '/assets/images/users/avatar-basic.jpg';
				// Handle accordingly here
			}
		}
		$html = view('notifications.render_new_notification', ['notifications' => $data['notifications']])->render();
		// dd($html);

		return response()->json(['html' => $html], 200);
	}
	public function edit($id)
	{
		$notification = Notification::with('user', 'userHasNotification.user')
			->where('id', $id)
			->whereHas('userHasNotification.user', function ($query) {
				$query->where('user_id', '>', 0);
			})
			->orderBy('created_at', 'desc')
			->first(); // Retrieve the notification as a single instance

		$users = User::all(); // Retrieve all users

		return view('notifications.edit', compact('notification', 'id', 'users'));
	}
	public function update(Request $request)
	{
		$notification_id = $request->input('notification_id');
		// Retrieve the notification
		$notification = Notification::find($notification_id);
		if (!$notification) {
			// Handle the case when the notification is not found
			// You can redirect back with an error message or return a JSON response
			return back()->with('error', 'Notification not found.');
		}
		// Update the notification with the new data
		// Modify the code below to update the fields according to your needs
		$notification->title = $request->input('title');
		$notification->content = $request->input('content');
		// Save the updated notification
		$notification->save();
		UserHasNotification::where('notification_id', $request->input('notification_id'))
			->delete();
		$selectedUsers = $request->input('selected_users');

		foreach ($selectedUsers as $selectedUser) {
			UserHasNotification::create([
				'notification_id' => $notification_id,
				'user_id' => $selectedUser,
				'mark_read' => 0
			]);
		}
		// Redirect to a success page or return a JSON response
		return redirect()->route('notifications')->with('success', 'Notification updated successfully.');
	}
	public function delete($id)
	{
		// Retrieve the notification
		$notification = Notification::find($id);
		if (!$notification) {
			// Handle the case when the notification is not found
			// You can redirect back with an error message or return a JSON response
			return back()->with('error', 'Notification not found.');
		}
		// Delete the notification
		$notification->delete();
		UserHasNotification::where('notification_id', $id)
			->delete();
		// Redirect to a success page or return a JSON response
		return redirect()->route('notifications')->with('success', 'Notification updated successfully.');
	}
}
