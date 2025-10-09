<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table			= 'users';
	protected $primaryKey		= 'id';
	protected $useTimestamps	= true;
	protected $allowedFields	= ['username', 'email', 'password_hash'];

	protected $validationRules = [
		'username'      => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
		'email'         => 'required|valid_email|max_length[191]|is_unique[users.email,id,{id}]',
		'password_hash' => 'permit_empty|min_length[8]|max_length[255]',
	];

	public function findByUsername(string $username)
	{
		return $this->where('username', $username)->first();
	}
}
