<?php

namespace Tests\Feature;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\PostModel;

class ApiPostTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $seed = 'DatabaseSeeder';
    protected $namespace = 'App';

    private function getAccessToken()
    {
        $userModel = new UserModel();
        $user = $userModel->findById(1); // SuperAdmin
        $token = $user->generateAccessToken('test_token');
        return $token->raw_token;
    }

    public function testGetPostsReturnsPublishedPosts()
    {
        $result = $this->get('/api/posts');

        $result->assertStatus(200);
        $result->assertJSONFragment(['status' => 'Published']);
        $result->assertJSONMissing(['status' => 'Draft']);
    }

    public function testGetSinglePostReturnsCorrectPost()
    {
        $post = model(PostModel::class)->where('status', 'Published')->first();
        $result = $this->get('/api/posts/' . $post->id);

        $result->assertStatus(200);
        $result->assertJSONFragment(['id' => $post->id, 'title' => $post->title]);
    }

    public function testCreatePostRequiresAuth()
    {
        $result = $this->post('/api/posts', [
            'title' => 'API Test Post',
            'content' => 'Content from API.',
            'category_id' => 1,
        ]);

        $result->assertStatus(401);
    }

    public function testCreatePostWithValidToken()
    {
        $token = $this->getAccessToken();

        $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

        $result = $this->post('/api/posts', [
            'title'       => 'API Created Post',
            'content'     => 'This post was created via API.',
            'category_id' => 1,
            'status'      => 'Published',
        ]);

        $result->assertStatus(201);
        $this->seeInDatabase('posts', ['title' => 'API Created Post']);
    }

    public function testUpdatePostWithValidToken()
    {
        $token = $this->getAccessToken();
        $post = model(PostModel::class)->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

        $result = $this->put('/api/posts/' . $post->id, [
            'title'   => 'API Updated Title',
            'content' => 'Updated via API.',
            'category_id' => $post->category_id,
        ]);

        $result->assertStatus(200);
        $this->seeInDatabase('posts', ['id' => $post->id, 'title' => 'API Updated Title']);
    }

    public function testDeletePostWithValidToken()
    {
        $token = $this->getAccessToken();
        $post = model(PostModel::class)->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

        $result = $this->delete('/api/posts/' . $post->id);

        $result->assertStatus(200);
        $this->dontSeeInDatabase('posts', ['id' => $post->id]);
    }
}