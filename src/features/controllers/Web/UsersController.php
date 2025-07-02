<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Models\Model; 
use Yohpal\Utils\Util;

class UsersController
{

    public $util; 

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util; 
    }

    /**
     * Returns the home page view to the user
     * 
     * @return view The home page.
     */
    public function index(YPRequest $request): mixed
    { 
        return view('index');
    }

    /**
     * Returns the users count stats
     * 
     * @return number
     */
    public function usersCount(YPRequest $request):mixed
    { 
        $data = [];

        try {
            $data = [
                'pending_users' => num_formatter(2944),
                'active_users' => num_formatter(6753),
                'dormant_users' => num_formatter(3633),
                'deleted_users' => num_formatter(378),
                'total_job_seekers' => num_formatter(74764),
                'total_job_providers' => num_formatter(28398),
                'active_listings' => num_formatter(2389)
            ];
        }
        catch(\Throwable $th) {
            YPLogger::error($th);
        }

        return $request->res(['status' => 'success', 'data' => $data]);
    }
    
}
