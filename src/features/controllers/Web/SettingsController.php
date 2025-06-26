<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication; 
use Yohpal\Utils\Util;

class SettingsController
{
    public $util;

    public $model;

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->model = new Authentication();
    }

    public function generalSettings(YPRequest $request): mixed
    {
        try {
            if (!isAjaxRequest()) { 
                return view('crm/settings/general');
            }
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function paymentMethods(YPRequest $request): mixed
    {
        try {
            if (!isAjaxRequest()) { 
                return view('crm/settings/payment-methods');
            }
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}