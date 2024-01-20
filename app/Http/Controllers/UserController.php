<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Roles;
use App\Models\UserHasNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
	const LIMIT = 8;
	public function loginForm()
	{
		if (Auth::check()) {
			return redirect(route('dashboard'));
		}

		return view('users.login-form');
	}

	public function index(Request $request)
	{
		if (isset($request->page)) {
			$skip = ($request->page - 1) * self::LIMIT;
			$page = $request->page;
		} else {
			$skip = 0;
			$page = 1;
		}

		$query = User::with('userRole');
		$count = $query->count();
		$data['arUsers'] = $query->take(self::LIMIT)->skip($skip)->get()->toArray();
		// $users = User::with('userRole')->get();

		$data['currentUser'] = Auth::user();

		// $count = 0;
		foreach ($data['arUsers'] as $user) {
			$data['avatarUsers'][$user['id']] = User::find($user['id'])->getMedia('avatar');
			// $count++;
		}


		$data['numPage'] = ceil($count / self::LIMIT);
		$data['currentPage'] = $page;


		return view('users.index', $data);
	}

	public function add()
	{
		$data['arRole'] = Roles::get()->pluck('name', 'id')->toArray();
		return view('users.add', $data);
	}

	public function edit(Request $request)
	{
		$data['user'] = User::with('userRole')->where('id', '=', $request->id)->get()->toArray();
		$data['arRole'] = Roles::get()->pluck('name', 'id')->toArray();
		$data['avatarUsers'][$request->id] = User::find($request->id)->getMedia('avatar');
		$user = Auth::user();

		if ($user->role_id == 1 || $user->id == $request->id) {
			return view('users.edit', $data);
		} else {
			return redirect(route('user.detail', $request->id));
		}
	}


	public function login(Request $request)
	{
		if (Auth::check()) {
			$user_login = Auth::user();
			$content = $user_login->name . ' đã đăng nhập';

			// Tạo thông báo
			Notification::create([
				'content' => $content,
				'sender_id' => $user_login->id,
			]);

			return redirect(route('dashboard'));
		}

		if (Auth::attempt(array(
			'email' => $request->input('email'),
			'password' => $request->input('password'),
		), $request->input('remember'))) {
			return redirect(route('dashboard'));
		} else {
			$error = 'login_error';
			return redirect()->back()->with('error', $error);
		}
	}

	public function logout()
	{
		if (Auth::check()) {
			Auth::logout();
		}

		return redirect(route('login'));
	}

	public function detail(Request $request)
	{
		$data['user'] = User::with('userRole')->where('id', '=', $request->id)->get()->toArray();
		$data['arRole'] = Roles::get()->pluck('name', 'id')->toArray();
		$data['avatarUsers'][$request->id] = User::find($request->id)->getMedia('avatar');
		return view('users.detail', $data);
	}

	public function update(Request $request)
	{
		if (empty($request->id)) {
			$request->validate([
				'name' => 'required',
				'password' => 'required',
				'email' => 'required'
			]);
			dd($request->role_id);
			$id = User::create(array(
				"name" => $request->name,
				"password" => Hash::make($request->password),
				"email" => $request->email,
				"role_id" => $request->role_id,
				"country" => $request->country,
				"phone" => $request->phone,
				"point_accumulated" => $request->point_accumulated,
				"expertise_coefficient" => $request->expertise_coefficient,
				"allowance" => $request->allowance
			))->id;

			if (isset($request->avatar) && !empty($request->avatar)) {
				$user = User::findOrFail($id);
				$user->addMedia($request->avatar)->toMediaCollection('avatar');
			}
		} else {
			$user = User::find($request->id);

			$user->email = $request->email;
			$user->name = $request->name;
			$user->role_id = $request->role_id;
			$user->country = $request->country;
			$user->phone = $request->phone;
			$user->point_accumulated = $request->point_accumulated;
			$user->expertise_coefficient = $request->expertise_coefficient;
			$user->allowance = $request->allowance;

			$user->save();

			if (isset($request->avatar) && !empty($request->avatar)) {
				$user->clearMediaCollection('avatar');
				$user->addMedia($request->avatar)->toMediaCollection('avatar');
			}
		}

		return redirect()->route('user.index');
	}
}
