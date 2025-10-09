<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SamplePostsSeeder extends Seeder
{
	public function run()
	{
		// Get admin user ID
		$admin = $this->db->table('users')->where('username', 'admin')->get()->getRow();
		if (!$admin) {
			echo "Admin user not found. Run AdminSeeder first.\n";
			return;
		}
		$posts = [
			[
				'user_id' => $admin->id,
				'title' => 'Dog CEO Zine',
				'slug' => 'dog-ceo-zine',
				'content' => 'A business and lifestyle magazine for the modern dog. Featuring training insights, grooming tips, and stories from successful canine entrepreneurs.',
				'status' => 'published',
				'published_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
				'image_url' => 'https://images.dog.ceo/breeds/waterdog-spanish/20190208_063211.jpg',
				'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
				'updated_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
			],
			[
				'user_id' => $admin->id,
				'title' => 'Majestic Cats Weekly',
				'slug' => 'majestic-cats-weekly',
				'content' => 'All about feline grace and attitude. Read interviews with cat lovers, discover rare breeds, and learn how to keep your cat happy and healthy.',
				'status' => 'published',
				'published_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
				'image_url' => 'https://cdn2.thecatapi.com/images/MTY3ODIyMQ.jpg',
				'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
				'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
			],
			[
				'user_id' => $admin->id,
				'title' => 'Parrot Planet',
				'slug' => 'parrot-planet',
				'content' => 'Everything you need to know about parrots. From macaws to cockatoos, we share care guides, nutrition facts, and parrot talk tips.',
				'status' => 'published',
				'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
				'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/Blue-and-yellow-macaw.jpg',
				'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
				'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
			],
			[
				'user_id' => $admin->id,
				'title' => 'Ocean Life Digest',
				'slug' => 'ocean-life-digest',
				'content' => 'Dive deep into the marine world. Explore coral reefs, discover sea creatures, and learn how to protect the ocean ecosystem.',
				'status' => 'published',
				'published_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
				'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Jelly_cc11.jpg',
				'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'user_id' => $admin->id,
				'title' => 'Reptile Realm (Draft)',
				'slug' => 'reptile-realm-draft',
				'content' => 'Upcoming post exploring reptiles like snakes, iguanas, and turtles. Stay tuned for detailed habitat and care information.',
				'status' => 'draft',
				'published_at' => null,
				'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/0c/Green_Iguana_-_Jurong_Bird_Park%2C_Singapore_-_20100123.jpg',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
		];

		foreach ($posts as $post) {
			$this->db->table('posts')->insert($post);
		}

		echo "Sample posts created successfully!\n";
	}
}
