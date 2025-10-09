<?php

namespace App\Libraries;

use App\Models\JobModel;

class JobService
{
    protected $jobModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
    }

    /**
     * Add a new job to the queue.
     *
     * @param string $jobType The type of job (e.g., 'send_email').
     * @param array  $payload The data required to process the job.
     */
    public function addJob(string $jobType, array $payload): void
    {
        $this->jobModel->save([
            'job_type' => $jobType,
            'payload'  => json_encode($payload),
            'status'   => 'pending',
            'attempts' => 0,
        ]);
    }
}