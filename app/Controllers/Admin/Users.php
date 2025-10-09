<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Models\UserIdentityModel;

class Users extends BaseController
{
    protected $userProvider;

    public function __construct()
    {
        $this->userProvider = auth()->getProvider();
    }

    public function index()
    {
        $data['users'] = $this->userProvider->withIdentities()->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data['groups'] = auth()->getAuthenticator()->getGroups();
        return view('admin/users/create', $data);
    }

    public function store()
    {
        $users = $this->userProvider;

        // Validate basics
        $rules = [
            'username' => 'required|string|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[auth_identities.secret]',
            'password' => 'required|strong_password',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $user = new User([
            'username' => $this->request->getPost('username'),
            'active'   => true,
        ]);
        $users->save($user);

        // Get the new user ID
        $user = $users->findById($users->getInsertID());

        // Create the email/password identity
        $user->createEmailIdentity([
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

        // Add to group
        $user->addGroup($this->request->getPost('group'));

        return redirect()->to('/admin/users')->with('message', 'User created successfully.');
    }

    public function edit($id)
    {
        $data['user'] = $this->userProvider->withIdentities()->findById($id);
        $data['groups'] = auth()->getAuthenticator()->getGroups();

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userProvider->findById($id);

        // Validate basics
        $rules = [
            'username' => "required|string|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[auth_identities.secret,user_id,{$id}]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'strong_password';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update user
        $user->fill([
            'username' => $this->request->getPost('username'),
        ]);
        $this->userProvider->save($user);

        // Update email identity
        $identity = $user->getIdentity('email_password');
        $identity->secret = $this->request->getPost('email');
        if ($this->request->getPost('password')) {
            $identity->secret2 = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        model(UserIdentityModel::class)->save($identity);


        // Sync groups
        $user->syncGroups($this->request->getPost('group'));

        return redirect()->to('/admin/users')->with('message', 'User updated successfully.');
    }

    public function delete($id)
    {
        // Prevent deleting self
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $this->userProvider->delete($id, true);

        return redirect()->to('/admin/users')->with('message', 'User deleted successfully.');
    }
}