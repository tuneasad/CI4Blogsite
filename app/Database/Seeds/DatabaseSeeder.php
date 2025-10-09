<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Users
        $users = auth()->getProvider();

        // SuperAdmin
        $user1 = new User([
            'username' => 'superadmin',
            'active'   => 1,
        ]);
        $users->save($user1);
        $user1 = $users->findById($users->getInsertID());
        $user1->createEmailIdentity(['email' => 'superadmin@example.com', 'password' => 'password']);
        $user1->addGroup('SuperAdmin');

        // Editor
        $user2 = new User([
            'username' => 'editor',
            'active'   => 1,
        ]);
        $users->save($user2);
        $user2 = $users->findById($users->getInsertID());
        $user2->createEmailIdentity(['email' => 'editor@example.com', 'password' => 'password']);
        $user2->addGroup('Editor');

        // Viewer
        $user3 = new User([
            'username' => 'viewer',
            'active'   => 1,
        ]);
        $users->save($user3);
        $user3 = $users->findById($users->getInsertID());
        $user3->createEmailIdentity(['email' => 'viewer@example.com', 'password' => 'password']);
        $user3->addGroup('Viewer');

        // Categories
        $categoryModel = new \App\Models\CategoryModel();
        $categoryModel->insertBatch([
            ['name' => 'Technology'],
            ['name' => 'Lifestyle'],
            ['name' => 'Travel'],
        ]);

        // Posts
        $postModel = new \App\Models\PostModel();
        $postModel->insertBatch([
            [
                'title' => 'First Post',
                'content' => 'This is the first post content.',
                'category_id' => 1,
                'author_id' => 1,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Second Post',
                'content' => 'This is the second post content.',
                'category_id' => 2,
                'author_id' => 2,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Third Post',
                'content' => 'This is the third post content.',
                'category_id' => 1,
                'author_id' => 1,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Fourth Post',
                'content' => 'This is the fourth post content.',
                'category_id' => 3,
                'author_id' => 2,
                'status' => 'Draft',
            ],
            [
                'title' => 'Fifth Post',
                'content' => 'This is the fifth post content.',
                'category_id' => 2,
                'author_id' => 1,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}