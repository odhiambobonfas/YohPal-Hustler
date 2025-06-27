<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication; 
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
                $hustleSuperCategories = Model::hustleCategories();
                $hustleMixedCategories = Model::hustleMixedCategories(); 
                return view('crm/job-portal/index', compact('hustleSuperCategories', 'hustleMixedCategories'));
            }
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function jobsListing(YPRequest $request, $path): mixed
    {
        try {
            $categoryId = getIdParam($path); 
            $hustleSuperCategories = Model::hustleCategories();
            $viewableSubCategories = Model::hustleSubCategoriesBySuperCategoryId($categoryId); 
            return $request->res(['status' => 'success', 'htmlContent' => view('job-portal/jobs-listing', compact('categoryId', 'hustleSuperCategories', 'viewableSubCategories'), true)]);
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}