<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Dashboard extends BaseController
{
	public function login()
	{
		$session = session();
		if ($session->get('user_id')) {
			return redirect()->to('/admin/posts');
		}
		return view('admin/login');
	}

	public function loginPost()
	{
		$session = session();
		if ($session->get('user_id')) {
			return redirect()->to('/admin/posts');
		}

		$rules = [
			'username' => 'required|min_length[3]',
			'password' => 'required|min_length[6]',
		];

		if (!$this->validate($rules)) {
			$data['validation'] = $this->validator;
			$data['error'] = 'Please fix the errors below.';
			$data['form'] = [
				'username' => (string) $this->request->getPost('username')
			];
			return view('admin/login', $data);
		}

		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		$userModel = new UserModel();
		$user = $userModel->findByUsername($username);
		if ($user && password_verify($password, $user['password_hash'])) {
			$session->set('user_id', $user['id']);
			$session->set('username', $user['username']);
			return redirect()->to('/admin/posts')->with('success', 'Welcome back, ' . $user['username'] . '!');
		}

		$data['error'] = 'Invalid Credentials';
		$data['form'] = ['username' => $username];
		return view('admin/login', $data);
	}
	
	public function logout()
	{
		session()->destroy();
		return redirect()->to('/admin/login')->with('success', 'Logged out successfully');
	}
	
	private function checkAuth()
	{
		if (!session()->get('user_id')) {
			return redirect()->to('/admin/login');
		}
	}
}
