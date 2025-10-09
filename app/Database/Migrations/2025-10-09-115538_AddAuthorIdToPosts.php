<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthorIdToPosts extends Migration
{
    public function up()
    {
        //
    }

    public function down()
    {
         $this->forge->addColumn('posts', [
        'author_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
            'after' => 'id',
        ],
    ]);
    }
}
