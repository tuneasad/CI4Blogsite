<?php

namespace Tests\Feature;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\PostModel;

class PostControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $seed = 'DatabaseSeeder';
    protected $namespace = 'App';

    protected function setUp(): void
    {
        parent::setUp();
        // Set up the session
        $this->session = \Config\Services::session();
    }

    public function testSuperAdminCanViewPosts()
    {
        $user = model(UserModel::class)->findById(1);

        $result = $this->actingAs($user)->get('/admin/posts');

        $result->assertStatus(200);
        $result->assertSee('Manage Posts');
    }

    public function testSuperAdminCanCreatePost()
    {
        $user = model(UserModel::class)->findById(1);

        // To simulate file upload, we need to create a dummy file
        $file = tempnam(sys_get_temp_dir(), 'test_image') . '.png';
        copy(APPPATH . '../public/favicon.ico', $file); // Use a real image file

        $_FILES['image'] = [
            'name'     => 'test_image.png',
            'type'     => 'image/png',
            'size'     => filesize($file),
            'tmp_name' => $file,
            'error'    => 0,
        ];

        $result = $this->actingAs($user)->post('/admin/posts/store', [
            'title'       => 'New Test Post',
            'content'     => 'This is a test post.',
            'category_id' => 1,
            'status'      => 'Published',
        ]);

        unlink($file); // Clean up the dummy file

        $result->assertStatus(302);
        $result->assertRedirectTo(site_url('/admin/posts'));

        $this->seeInDatabase('posts', ['title' => 'New Test Post']);
    }

    public function testSuperAdminCanEditPost()
    {
        $user = model(UserModel::class)->findById(1);
        $post = model(PostModel::class)->first();

        $result = $this->actingAs($user)->post('/admin/posts/update/' . $post->id, [
            'title'   => 'Updated Title',
            'content' => 'Updated content.',
            'category_id' => $post->category_id,
            'status' => $post->status
        ]);

        $result->assertStatus(302);
        $result->assertRedirectTo(site_url('/admin/posts'));
        $this->seeInDatabase('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    }

    public function testSuperAdminCanDeletePost()
    {
        $user = model(UserModel::class)->findById(1);
        $post = model(PostModel::class)->first();

        $result = $this->actingAs($user)->post('/admin/posts/delete/' . $post->id);

        $result->assertStatus(302);
        $result->assertRedirectTo(site_url('/admin/posts'));
        $this->dontSeeInDatabase('posts', ['id' => $post->id]);
    }
}