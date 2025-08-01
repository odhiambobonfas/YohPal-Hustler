<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Models\Authentication;
use Yohpal\Models\Category;
use Yohpal\Models\Job;
use Yohpal\Utils\Util;


class JobsController
{
    public $util;

    public $model;

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->model = new Authentication();
    }

    public function index(YPRequest $request): mixed
    {
        try {
            if (!isAjaxRequest()) {
                $hustleSuperCategories = Category::hustleCategories();
                $hustleMixedCategories = Category::hustleCategories();
                return view('crm/job-portal/index', compact('hustleSuperCategories', 'hustleMixedCategories'));
            }
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
    /**
     * @param mixed $path
     */
    public function createJobDraft(YPRequest $request, $path): mixed
    {
        try {
            $input = $request->req();
            $params = getIdParams($path);

            if (!isset($params[0]) || !isset($params[1])) {
                throw new YPRequest('An error occurred when trying to draft your job request. Please try again!');
            }

            if (
                empty($input["name"])
                    || empty($input["description"])
                    || empty($input["endDateTime"])
                    || empty($input["startDateTime"])
                    || empty($input["hustlersCount"])
            ) {
                throw new \Exception('Missing required fields. Please try again!');
            }

            Auth::create('newJob', $input);

            return $request->res(['status' => 'success', "data" => $input, "newJob" => $input, 'message' => "Job drafted successfully!"]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "rawMsg" => $th->getMessage(), "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function createJob(YPRequest $request): mixed
    {
        try {
            $input = $request->req();
            $cached = Auth::get("newJob");

            $jobData = [
                "ownerId" => auth()->user()->uid,
                "ownerName" => auth()->user()->userName ?? "",
                "jobDetails" => [
                    "name" => $cached->name,
                    "startTime" => $cached->startDateTime,
                    "endTime" => $cached->endDateTime,
                    "hustlersCount" => $cached->hustlersCount,
                    "description" => $cached->description,
                    "jobSite" => $input["locationDetails"],
                    "hustlers"=> $input["hustlerIds"],
                ],
            ];

            $job = new Job();
            $r = $job->createJob($jobData);

            return $request->res(["status" => "success", "resp" =>$r]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "rawMsg" => $th->getMessage(), "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function acceptJob(YPRequest $request): mixed {
        try {
            $input = $request->req();
            $jobId = $input["jobId"];

            if (empty($jobId)) {
                throw new \Exception("Missing jobId");
            }

            $uid = Auth::user()->uid;
            $job = new Job();

            $job->acceptJob(["jobId" => $jobId, "hustlerId" =>$uid]);


            return $request->res(["status" => 'success', "message" => $jobId]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "rawMsg" => $th->getMessage(), "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function rejectJob(YPRequest $request):mixed {

        try {
            $input = $request->req();
            $jobId = $input["jobId"];
            if (empty($jobId)) {
                throw new \Exception("Missing jobId");
            }

            $uid = Auth::user()->uid;
            $job = new Job();

            $job->rejectJob(["jobId" => $jobId, "hustlerId" => $uid]);

            return $request->res(["status" => 'success', "message" => $jobId]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "rawMsg" => $th->getMessage(), "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
    /**
     * @param mixed $path
     */
    public function getServices(YPRequest $request, $path): mixed
    {
        try {
            $data=Category::hustleCategories();
            return $request->res(["status" => "success", "services" => $data]);

        } catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "rawMsg" => $th->getMessage(), "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}
