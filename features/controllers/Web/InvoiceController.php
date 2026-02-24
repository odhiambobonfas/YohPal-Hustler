<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\YPLogger;
use Yohpal\Utils\Util;

class InvoiceController
{
    public $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    public function show(YPRequest $request): mixed
    {
        try {
            $jobId = $request->get('job_id');
            
            if (!$jobId) {
                return $request->res(['status' => 'error', 'message' => 'Job ID is required']);
            }

            return view('Invoice/invoice', ['jobId' => $jobId]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(['status' => 'error', 'message' => 'Failed to load invoice']);
        }
    }

    public function getJobData(YPRequest $request): mixed
    {
        try {
            $jobId = $request->get('job_id');
            
            if (!$jobId) {
                return $request->res(['status' => 'error', 'message' => 'Job ID is required']);
            }

            // TODO: Implement actual Firebase fetch logic
            // This endpoint is currently not used as frontend fetches directly from Firebase
            
            return $request->res(['status' => 'error', 'message' => 'Not implemented - use Firebase directly']);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(['status' => 'error', 'message' => 'Failed to fetch job data']);
        }
    }
}
