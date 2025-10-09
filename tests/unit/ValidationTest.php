<?php

namespace Tests\Unit;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;

class ValidationTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'DatabaseSeeder';
    protected $namespace = 'App';

    public function testPostValidationFailsWithShortTitle()
    {
        $postModel = new PostModel();
        $data = [
            'title'       => 'A',
            'content'     => 'This is a test post.',
            'category_id' => 1,
            'status'      => 'Published',
            'author_id'   => 1,
        ];

        $this->assertFalse($postModel->insert($data));
        $this->assertArrayHasKey('title', $postModel->errors());
    }

    public function testCategoryValidationFailsWithDuplicateName()
    {
        $categoryModel = new CategoryModel();
        $categoryModel->insert(['name' => 'Tech']); // Insert first category

        $data = ['name' => 'Tech'];

        $this->assertFalse($categoryModel->insert($data));
        $this->assertArrayHasKey('name', $categoryModel->errors());
    }

    public function testTagValidationPassesWithValidData()
    {
        $tagModel = new TagModel();
        $data = ['name' => 'New Tag'];

        $this->assertIsNumeric($tagModel->insert($data));
        $this->assertCount(0, $tagModel->errors());
    }
}