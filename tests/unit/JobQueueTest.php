<?php

namespace Tests\Unit;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\JobModel;
use App\Libraries\JobService;

class JobQueueTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'DatabaseSeeder';
    protected $namespace = 'App';

    public function testAddJobToQueue()
    {
        $jobService = new JobService();
        $jobService->addJob('send_email', ['to' => 'test@example.com']);

        $this->seeInDatabase('jobs', ['job_type' => 'send_email', 'status' => 'pending']);
    }

    public function testProcessJobSuccessfully()
    {
        $jobService = new JobService();
        $jobService->addJob('send_email', [
            'to'      => 'test@example.com',
            'subject' => 'Test Email',
            'view'    => 'emails/new_post_notification',
            'data'    => ['post' => (object)['title' => 'Test', 'slug' => 'test']],
        ]);

        $result = $this->spark('jobs:run');

        $result->assertSee('processed successfully');
        $this->seeInDatabase('jobs', ['job_type' => 'send_email', 'status' => 'completed']);
    }

    public function testHandleFailedJob()
    {
        $jobModel = new JobModel();
        // Create a job that will fail (e.g., invalid email payload)
        $jobModel->insert([
            'job_type' => 'send_email',
            'payload'  => json_encode(['to' => 'invalid-email']),
            'status'   => 'pending',
            'attempts' => 2, // Start with 2 attempts
        ]);

        $result = $this->spark('jobs:run');

        $result->assertSee('failed');
        $this->seeInDatabase('jobs', [
            'job_type' => 'send_email',
            'status'   => 'failed',
            'attempts' => 3,
        ]);
    }
}