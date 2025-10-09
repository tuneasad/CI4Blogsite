<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Check if data already exists to prevent duplication
        $userModel = auth()->getProvider();
        if ($userModel->find(1)) {
            // Assuming if user 1 exists, the seeder has been run
            return;
        }

        // Create Users
        $superadmin = $this->createUser([
            'username' => 'superadmin',
            'email'    => 'superadmin@example.com',
            'password' => 'password',
            'group'    => 'SuperAdmin',
        ]);

        $editor = $this->createUser([
            'username' => 'editor',
            'email'    => 'editor@example.com',
            'password' => 'password',
            'group'    => 'Editor',
        ]);

        $viewer = $this->createUser([
            'username' => 'viewer',
            'email'    => 'viewer@example.com',
            'password' => 'password',
            'group'    => 'Viewer',
        ]);

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
                'author_id' => $superadmin->id,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Second Post',
                'content' => 'This is the second post content.',
                'category_id' => 2,
                'author_id' => $editor->id,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Third Post',
                'content' => 'This is the third post content.',
                'category_id' => 1,
                'author_id' => $superadmin->id,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Fourth Post',
                'content' => 'This is the fourth post content.',
                'category_id' => 3,
                'author_id' => $editor->id,
                'status' => 'Draft',
            ],
            [
                'title' => 'Fifth Post',
                'content' => 'This is the fifth post content.',
                'category_id' => 2,
                'author_id' => $superadmin->id,
                'status' => 'Published',
                'published_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Helper method to create a new user with an email/password identity
     * and add them to a group.
     */
    private function createUser(array $data): User
    {
        $users = auth()->getProvider();

        $user = new User([
            'username' => $data['username'],
            'active'   => 1,
        ]);
        $users->save($user);

        // To get the complete user object with ID, we need to retrieve it
        $user = $users->findById($users->getInsertID());

        // Create email/password identity
        $user->createEmailIdentity([
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        // Add to group
        $user->addGroup($data['group']);

        return $user;
    }
}