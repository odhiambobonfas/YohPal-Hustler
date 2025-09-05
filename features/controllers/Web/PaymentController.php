<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication; 
use Yohpal\Utils\Util;

class PaymentController
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
                return view('crm/payments/index');
            }
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function dashboardEarningsData(YPRequest $request): mixed
    {
        try {
            $data = [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
                'earnings' => [12000, 8000, 16000, 6000, 14000, 10000, 18000]
            ];
    
            return $request->res([
                'status' => 'success',
                'data' => $data
            ]);
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}