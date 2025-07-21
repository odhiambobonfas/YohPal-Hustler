<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication;
use Yohpal\Models\Category;
use Yohpal\Utils\Util;

use function Symfony\Component\Translation\t;

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

    public function jobsListing(YPRequest $request, $path): mixed
    {
        try {
            $category['slug'] = getIdParam($path);
            $hustleSuperCategories = Category::hustleCategories();
            $viewableSubCategories = Category::hustleSubCategoriesBySlug($category['slug']);
            return $request->res(['status' => 'success', 'htmlContent' => view('job-portal/jobs-listing', compact('category', 'hustleSuperCategories', 'viewableSubCategories'), true)]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function createJobDraft(YPRequest $request, $path)
    {
        try {
            $input = $request->req();
            $params = getIdParams($path);

            if (!isset($params[0]) || !isset($params[1])) {
                throw new YPRequest('An error occurred when trying to draft your job request. Please try again!');
            }

            if (
                empty($input["description"]) || empty($input["endDateTime"])
                || empty($input["startDateTime"])
                || empty($input["hustlersCount"])
            ) {
                throw new \Exception('Missing required fields. Please try again!');
                // throw new YPRequest("Missing required fields. Please try again!");
            }

            $input['superCategoryId'] = $params[0];
            $input['subCategoryId'] = $params[1];

            Auth::create('newJob', $input);

            return $request->res(['status' => 'success', "data" => $input, 'message' => "Job drafted successfully!", 'categoryObj' => ['superCategory' => $input['superCategoryId'], 'subCategory' => $input['subCategoryId']]]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "rawMsg" => $th->getMessage(), "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}
