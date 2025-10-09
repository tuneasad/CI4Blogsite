<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\JobModel;

class JobsRun extends BaseCommand
{
    protected $group       = 'Jobs';
    protected $name        = 'jobs:run';
    protected $description = 'Processes pending jobs from the queue.';

    public function run(array $params)
    {
        $jobModel = new JobModel();
        $jobs = $jobModel->where('status', 'pending')->findAll();

        if (empty($jobs)) {
            CLI::write('No pending jobs to process.', 'green');
            return;
        }

        CLI::write(sprintf('Processing %d pending jobs...', count($jobs)));

        foreach ($jobs as $job) {
            try {
                $this->processJob($job);
                $jobModel->update($job->id, ['status' => 'completed']);
                CLI::write(sprintf('Job #%d (%s) processed successfully.', $job->id, $job->job_type), 'green');
            } catch (\Exception $e) {
                $job->attempts++;
                $status = ($job->attempts >= 3) ? 'failed' : 'pending';
                $jobModel->update($job->id, ['status' => $status, 'attempts' => $job->attempts]);
                CLI::error(sprintf('Job #%d (%s) failed: %s', $job->id, $job->job_type, $e->getMessage()));
            }
        }

        CLI::write('All jobs processed.', 'green');
    }

    protected function processJob($job)
    {
        $payload = json_decode($job->payload, true);

        switch ($job->job_type) {
            case 'send_email':
                $this->sendEmail($payload);
                break;
            default:
                throw new \Exception('Unknown job type: ' . $job->job_type);
        }
    }

    protected function sendEmail(array $payload)
    {
        $email = \Config\Services::email();

        $email->setTo($payload['to']);
        $email->setSubject($payload['subject']);
        $email->setMessage(view($payload['view'], $payload['data']));

        if (!$email->send()) {
            throw new \Exception('Failed to send email: ' . $email->printDebugger(['headers']));
        }
    }
}