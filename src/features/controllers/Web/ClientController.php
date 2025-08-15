<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Client;
use Yohpal\Utils\Util;
use Yohpal\Utils\CommUtil;
use Yohpal\Utils\HustleUtil;
use function Yohpal\Application\Auth;

class ClientController
{
    public $model;

    public $util;

    public $commUtil;

    public $hustleUtil;

    public function __construct(Util $util, CommUtil $commUtil, HustleUtil $hustleUtil)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->commUtil = $commUtil;
        $this->hustleUtil = $hustleUtil;
    }

    /*
    * Toggles in app, if the user is an active hustler or not
    *
    * @return array<string,string>
    */
    public function toggleAccount(YPRequest $request): array
    {

        $hustlerStatus = Auth::get("hustlerStatus") ?? (object)["isHustler" => false];
        $hustlerStatus->isHustler = !$hustlerStatus->isHustler;
        Auth::create("hustlerStatus", $hustlerStatus);


        return $request->res(["route"=> $hustlerStatus->isHustler ? "/hustler/profile" : "/profile"]);
    }


    public function clientActivities(YPRequest $request): mixed
    {
        try {
            $clientModel = new Client();
            $userId = Auth::user()->uid;
            $data = $clientModel->getJobHistory(['ownerId' => $userId]);

            $jobHistory = $data ?? [];
            $authRole = !empty(Auth::get('role')) && isset(Auth::get('role')->role) ? strtolower(Auth::get('role')->role) : null;

            return view('crm/dashboard/activities-ui', compact('authRole', "jobHistory"));
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function getClientsJobHistory(YPRequest $request): mixed
    {
        try {
            $clientModel = new Client();
            $userId = Auth::user()->uid;
            $data = $clientModel->getJobHistory(['ownerId' => $userId]);

            $jobHistory = $data ?? [];
            return $request->res(['status' => 'success', 'jobHistory' => $jobHistory]);

        }catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }

    }

}
