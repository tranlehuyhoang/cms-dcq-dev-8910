<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Tasks;
use App\Models\Roles;
use App\Models\User;
use App\Models\Projects;
use App\Models\TaskComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskController extends BaseController
{
	public function index()
	{
		$user = Auth::user();
		$data['role']  = Roles::where('id', $user->role_id)->value('code');
		$data['arRoles'] = Roles::whereIn('code', [User::ADMIN, User::MANAGER])->get()->pluck('name', 'id')->toArray();
		if ($data['role'] == 'admin') {
			# code...
			$data['arTasks'] = Tasks::with('tasksAssignTo')->with('tasksCreatedBy')->with('tasksApprovedBy')->where('parent_id', '=', 0)->get()->keyBy('id')->toArray();
			foreach ($data['arTasks'] as $taskId => $task) {

				$hasChildren = Tasks::where('parent_id', '=', $taskId)->exists();

				$data['arTasks'][$taskId]['hasChildren'] = $hasChildren;

				$level = 0;
				$parentId = $task['parent_id'];
				while ($parentId != 0) {
					$level++;
					$parentId = Tasks::where('id', $parentId)->value('parent_id');
				}
				$data['arTasks'][$taskId]['level'] = $level;

				$user = User::find($data['arTasks'][$taskId]['assign_to']);
				$avatar = $user->getFirstMedia('avatar');
				$hasAvatar = $user->hasMedia('avatar');
				if ($hasAvatar) {
					$data['arTasks'][$taskId]['avatar'] = $avatar->getUrl();
				} else {
					$data['arTasks'][$taskId]['avatar'] = '/assets/images/users/avatar-basic.jpg';
					// Xử lý tương ứng tại đây
				}
			}
		} else {
			$data['arTasks'] = Tasks::with('tasksAssignTo')
				->with('tasksCreatedBy')
				->with('tasksApprovedBy')
				->where('parent_id', '=', 0)
				->get()
				->keyBy('id')
				->toArray();

			// dd($data['arTasks']);

			foreach ($data['arTasks'] as $taskId => $task) {
				$hasChildren = Tasks::where('parent_id', '=', $taskId)->exists();
				if (!$hasChildren && $task['assign_to'] != $user->id) {
					unset($data['arTasks'][$taskId]);
				}
			}
			foreach ($data['arTasks'] as $taskId => $task) {

				$hasChildren = Tasks::where('parent_id', '=', $taskId)->exists();

				$data['arTasks'][$taskId]['hasChildren'] = $hasChildren;

				$level = 0;
				$parentId = $task['parent_id'];
				while ($parentId != 0) {
					$level++;
					$parentId = Tasks::where('id', $parentId)->value('parent_id');
				}
				$data['arTasks'][$taskId]['level'] = $level;

				$user = User::find($data['arTasks'][$taskId]['assign_to']);
				$avatar = $user->getFirstMedia('avatar');
				$hasAvatar = $user->hasMedia('avatar');
				if ($hasAvatar) {
					$data['arTasks'][$taskId]['avatar'] = $avatar->getUrl();
				} else {
					$data['arTasks'][$taskId]['avatar'] = '/assets/images/users/avatar-basic.jpg';
					// Xử lý tương ứng tại đây
				}
			}
			// dd($data['arTasks_user']);
		}
		// dd($data['arTasks']);

		// dd($data['notifications']);

		$data['arProject'] = Projects::get()->pluck('name', 'id')->toArray();
		$data['user_id'] = $user->id;

		return view('tasks.index', $data);
	}

	public function detail(Request $request)
	{
		$user = Auth::user();
		$taskId = $request->id;
		$data = array();

		$data['role']  = Roles::where('id', $user->role_id)->value('code');


		$data['task'] = Tasks::with('tasksAssignTo')->with('tasksCreatedBy')->with('tasksApprovedBy')->where('id', '=', $request->id)->get()->toArray();
		// dd($data['task']);
		$data['project_id'] =  $data['task'][0]['project_id'];
		// $data['arChildTasks'] = Tasks::with('tasksAssignTo')->with('tasksCreatedBy')->with('tasksApprovedBy')->where('parent_id', '=', $request->id)->get()->toArray();
		$data['arChildTasks'] = Tasks::with('tasksAssignTo')->with('tasksCreatedBy')->with('tasksApprovedBy')->where('parent_id', '=', 0)->get()->keyBy('id')->toArray();
		foreach ($data['arChildTasks'] as $taskId => $task) {

			$hasChildren = Tasks::where('parent_id', '=', $taskId)->exists();

			$data['arChildTasks'][$taskId]['hasChildren'] = $hasChildren;

			$level = 0;
			$parentId = $task['parent_id'];
			while ($parentId != 0) {
				$level++;
				$parentId = Tasks::where('id', $parentId)->value('parent_id');
			}
			$data['arChildTasks'][$taskId]['level'] = $level;

			$user = User::find($data['arChildTasks'][$taskId]['assign_to']);
			$avatar = $user->getFirstMedia('avatar');
			$hasAvatar = $user->hasMedia('avatar');
			if ($hasAvatar) {
				$data['arChildTasks'][$taskId]['avatar'] = $avatar->getUrl();
			} else {
				$data['arChildTasks'][$taskId]['avatar'] = '/assets/images/users/avatar-basic.jpg';
				// Xử lý tương ứng tại đây
			}
		}
		$data['arStatus'] = Tasks::STATUS;
		$data['arPriority'] = Tasks::PRIORITY;
		$data['task_id'] = $request->id;

		$data['taskComments'] = TaskComment::where('task_id', '=', $request->id)->get();

		$data['user_id'] =  Auth::user()->id;


		$data['taskComments'] = TaskComment::with('user')
			->where('task_id', $request->id)
			->where('reply_id', 0)
			->orderBy('created_at', 'desc')
			->take(3)
			->get();

		// Chuyển đổi múi giờ và định dạng thời gian cho mỗi TaskComment
		foreach ($data['taskComments'] as $taskComment) {
			$createdDate = \Carbon\Carbon::parse($taskComment->created_at)->setTimezone('Asia/Ho_Chi_Minh');
			$taskComment->diffForHumansInVietnam = $createdDate->diffForHumans();
		}

		$data['taskCommentsWithReplyCount'] = [];

		foreach ($data['taskComments'] as $taskComment) {
			$taskComment->replyCount = TaskComment::where('reply_id', $taskComment->id)->count();
			$data['taskCommentsWithReplyCount'][] = $taskComment;
		}
		$user = User::find($data['task'][0]['assign_to']);

		$avatar = $user->getFirstMedia('avatar');
		$hasAvatar = $user->hasMedia('avatar');
		if ($hasAvatar) {
			$data['avatar'] =
				$avatar->getUrl();
		} else {
			$data['avatar'] =
				'/assets/images/users/avatar-basic.jpg';
			// Xử lý tương ứng tại đây
		}

		// Chuyển đổi múi giờ và định dạng thời gian cho mỗi TaskComment có reply_id khác 0

		// Chuyển đổi múi giờ và định dạng thời gian cho mỗi TaskComment có reply_id khác 0


		$data['taskCommentss'] = TaskComment::where('task_id', '=', $request->id)->get();

		$data['commentCount'] = count($data['taskCommentss']);
		$task = Tasks::find($request->id);
		$data['media'] = $task->getMedia('task_files');
		// dd($data['media'])
		return view('tasks.detail', $data);
	}



	public function add(Request $request)
	{
		$user = Auth::user();
		$data['role']  = Roles::where('id', $user->role_id)->value('code');
		if ($data['role'] !== 'admin') {
			return redirect()->back();
		}
		$data['users'] = User::get()->pluck('name', 'id')->toArray();

		$data['parentId'] = $request->parent_id;

		$data['parentTask'] = array();
		$data['taskCode'] = '';

		if ($data['parentId'] != 0) {
			$data['parentTask'] = Tasks::with('tasksAssignTo')->with('tasksCreatedBy')->with('tasksApprovedBy')->where('id', '=', $data['parentId'])->get()->toArray();
		}

		$data['arProject'] = Projects::get()->pluck('name', 'id')->toArray();

		// dd($data);

		return view('tasks.add', $data);
	}

	public function edit(Request $request)
	{
		$user = Auth::user();
		$data['role']  = Roles::where('id', $user->role_id)->value('code');
		if ($data['role'] !== 'admin') {
			return redirect()->back();
		}
		$data['task'] = Tasks::with('tasksAssignTo')->with('tasksCreatedBy')->with('tasksApprovedBy')->where('id', '=', $request->id)->get()->toArray();

		$data['users'] = User::get()->pluck('name', 'id')->toArray();

		$data['arStatus'] = Tasks::STATUS;
		$data['arPriority'] = Tasks::PRIORITY;

		return view('tasks.edit', $data);
	}


	public function update(Request $request)
	{
		if (empty($request->task['id'])) {
			$taskId = Tasks::create(array(
				"project_id" => $request->task["project_id"],
				"parent_id" => $request->task["parent_id"],
				"name" => $request->task["name"],
				"description" => $request->task["description"],
				"assign_to" => $request->task["assign_to"],
				"approved_by" => $request->task["approved_by"],
				"due_date" => $request->task["due_date"],
				"task_value" => $request->task["task_value"],
				"priority" => $request->task["priority"],
				"status" => $request->task["status"],
			))->id;
		} else {
			$taskId = $request->task["id"];
			$task = Tasks::find($request->task["id"]);

			$task->name = $request->task["name"];
			$task->description = $request->task["description"];
			$task->assign_to = $request->task["assign_to"];
			$task->approved_by = $request->task["approved_by"];
			$task->task_value = $request->task["task_value"];
			$task->due_date = $request->task["due_date"];
			$task->priority = $request->task["priority"];
			$task->status = $request->task["status"];

			$task->save();
		}

		return redirect()->route('task.detail', ['id' => $taskId]);
	}

	public function get_child_tasks(Request $request)
	{
		$id = $request->input('id');
		$arTasks = Tasks::with('tasksAssignTo')
			->with('tasksCreatedBy')
			->with('tasksApprovedBy')
			->where('parent_id', $id)
			->get()
			->keyBy('id')
			->toArray();

		foreach ($arTasks as $taskId => $task) {
			// Check if there are child tasks with parent_id = $taskId
			$hasChildren = Tasks::where('parent_id', $taskId)->exists();

			// Assign the value of `hasChildren` to the current task
			$arTasks[$taskId]['hasChildren'] = $hasChildren;

			// Calculate the level of the current task
			$level = 0;
			$parentId = $task['parent_id'];
			$parentIds = [];
			while ($parentId != 0) {
				$level++;
				$parentTask = Tasks::find($parentId);
				if ($parentTask) {
					$parentId = $parentTask->parent_id;
					$parentIds[] = $parentId;
				} else {
					break;
				}
			}
			$arTasks[$taskId]['level'] = $level;
			$arTasks[$taskId]['parentIds'] = array_reverse($parentIds);

			// Get the avatar path using HasMedia
			$avatarPath = '/assets/images/users/avatar-basic.jpg';
			$user = User::find($task['assign_to']);

			$avatar = $user->getFirstMedia('avatar');
			$hasAvatar = $user->hasMedia('avatar');
			if ($hasAvatar) {
				$arTasks[$taskId]['avatar'] = $avatar->getUrl();
			} else {
				$arTasks[$taskId]['avatar'] = '/assets/images/users/avatar-basic.jpg';
				// Xử lý tương ứng tại đây
			}
		}

		$html = view('tasks.render_child_tasks', ['arTasks' => $arTasks])->render();

		return response()->json(['html' => $html], 200);
	}
	public function upload_media(Request $request)
	{
		$user = Auth::user();
		$data['role']  = Roles::where('id', $user->role_id)->value('code');

		$taskId = $request->input('task_id');
		$task = Tasks::find($taskId);

		if ($request->hasFile('file')) {
			$file = $request->file('file');
			$task->addMedia($file)->toMediaCollection('task_files');
		}

		return response()->json(['message' => 'Media uploaded successfully.']);
	}
}
