<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPException;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Models\Hustler;
use Yohpal\Models\Model;
use Yohpal\Models\Client;
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

    public function jobHistory(YPRequest $request):mixed
    {
        try {
            $hustlerStatus = Auth::hustlerStatus();

            $clientModel = new Client();
            $hustlerModel = new Hustler();

            $userId = Auth::user()->uid;
            $data = [];
            if ($hustlerStatus->isHustler) {
                $data = $hustlerModel->getHustlerJobRequests(["hustlerId", $userId]);
            } else {
                $data = $clientModel->getJobHistory(["ownerId" => $userId]);
            }


            $html = view("crm/user-job-history-preview", compact("data"));

            return $request->res(["status"=>"success"]);

        } catch(YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }

    }

}
