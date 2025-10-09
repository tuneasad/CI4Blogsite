<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosts extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'            => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'user_id'       => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
			'title'         => [
				'type'       => 'VARCHAR',
				'constraint' => 200,
			],
			'slug'          => [
				'type'       => 'VARCHAR',
				'constraint' => 200,
			],
			'content'       => [
				'type' => 'TEXT',
			],
			'status'        => [
				'type'       => 'ENUM',
				'constraint' => ['draft', 'published'],
				'default'    => 'draft',
			],
			'published_at'  => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'created_at'    => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at'    => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addUniqueKey('slug');
		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('posts', true, ['ENGINE' => 'InnoDB', 'DEFAULT CHARSET' => 'utf8mb4']);
	}

	public function down()
	{
		$this->forge->dropTable('posts', true);
	}
}
