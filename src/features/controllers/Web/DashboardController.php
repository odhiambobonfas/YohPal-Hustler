<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication; 
use Yohpal\Utils\Util;

class DashboardController
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
                $hustleCategories = Model::hustleCategories();
                $hustleCategoriesDropdown = Model::hustleCategoriesDropdownOptions();

                $stats = [
                    ['label' => 'Pending Users', 'slug' => 'pending_users', 'value' => '18,316', 'class' => 'pending', 'dash' => '80'],
                    ['label' => 'Active Users', 'slug' => 'active_users', 'value' => '540', 'class' => 'active', 'dash' => '170'],
                    ['label' => 'Dormant Users', 'slug' => 'dormant_users', 'value' => '156', 'class' => 'dormant', 'dash' => '70'],
                    ['label' => 'Deleted Users', 'slug' => 'deleted_users', 'value' => '50', 'class' => 'deleted', 'dash' => '60'],
                ];

                return view('crm/dashboard/index', compact('stats', 'hustleCategories', 'hustleCategoriesDropdown'));
            }
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}