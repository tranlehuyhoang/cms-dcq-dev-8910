<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\UserHasNotificationController;
use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use App\Models\TaskComment;

Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
});

Route::get('/', [UserController::class, 'loginForm'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.store');
Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
	Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

	// Doanh thu
	Route::get('revenue', [RevenueController::class, 'index'])->name('revenue.index');

	// Khách hàng
	Route::get('customers', [CustomerController::class, 'index'])->name('customer.index');
	Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');


	// Dự án
	Route::get('projects', [ProjectsController::class, 'index'])->name('projects.index');
	Route::get('project/add', [ProjectsController::class, 'add'])->name('project.add');
	Route::post('project/update', [ProjectsController::class, 'update'])->name('project.update');
	Route::get('project/{id}/edit', [ProjectsController::class, 'edit'])->name('project.edit');

	// Nhiệm vụ
	Route::get('tasks', [TaskController::class, 'index'])->name('task.index');
	Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
	Route::post('tasks/update', [TaskController::class, 'update'])->name('task.update');
	Route::get('tasks/{parent_id}/add', [TaskController::class, 'add'])->name('task.add');
	Route::get('tasks/{id}', [TaskController::class, 'detail'])->name('task.detail');
	Route::post('tasks/get_child_tasks', [TaskController::class, 'get_child_tasks'])->name('task.get_child_tasks');
	Route::post('tasks/upload_media', [TaskController::class, 'upload_media'])->name('task.upload_media');

	// Người dùng
	Route::get('user/add', [UserController::class, 'add'])->name('user.add');
	Route::post('user/update', [UserController::class, 'update'])->name('user.update');
	Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
	Route::get('user/{id}', [UserController::class, 'detail'])->name('user.detail');
	Route::get('users', [UserController::class, 'index'])->name('user.index');
	Route::get('user/page/{page}', [UserController::class, 'index'])->name('user.page');

	// Comment
	Route::post('comment/create', [TaskCommentController::class, 'store'])->name('taskcomment.create');
	Route::post('comment/pagination', [TaskCommentController::class, 'pagination'])->name('taskcomment.pagination');
	Route::post('comment/getcommentlevel2', [TaskCommentController::class, 'getcommentlevel2'])->name('taskcomment.getcommentlevel2');
	Route::post('comment/getcommentlevel3', [TaskCommentController::class, 'getcommentlevel3'])->name('taskcomment.getcommentlevel3');

	//Notification
	Route::get('notification/new', [NotificationController::class, 'getNewNotification'])->name('notification.new');
	Route::get('notification/read', [UserHasNotificationController::class, 'markAsRead'])->name('notification.read');
	Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
});
