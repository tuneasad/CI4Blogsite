<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
	public function run()
	{
		$password = password_hash('password', PASSWORD_DEFAULT);
		$this->db->table('users')->insert([
			'username' => 'admin',
			'email' => 'dev@admin.com',
			'password_hash' => $password,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		]);
	}
}
