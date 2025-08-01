<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Hustler;
use Yohpal\Models\Authentication;
use Yohpal\Utils\Util;
use Yohpal\Utils\CommUtil;
use Yohpal\Utils\HustleUtil;

class HustlersController
{
    public $model;

    public $util;

    public $commUtil;

    public $hustleUtil;

    public $hustlerModel;

    public $hustler;

    public function __construct(Util $util, CommUtil $commUtil, HustleUtil $hustleUtil)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->commUtil = $commUtil;
        $this->hustleUtil = $hustleUtil;
        $this->hustler = new Hustler();
    }
    public function index(YPRequest $request)
    {
        $hustlerStatus = Auth::get("hustlerStatus") ?? (object)["isHustler" => false];
        if (!$hustlerStatus->isHustler) {
            header("Location: /dashboard");
            return;
        }

        return view("crm/hustlers/index");
    }

    public function profile(YPRequest $request): mixed {
        $response = $this->hustler->getHustlerProfile();
        return view("crm/hustlers/profile");
    }

    public function getActiveHustlersByPrimarySkill(YPRequest $request): mixed
    {
        try {
            $this->hustlerModel = new Hustler();
            $jobDraft = Auth::get('newJob');
            $hustlers = $this->hustlerModel->getActiveHustlersByPrimarySkill(['primarySkill' => $jobDraft->name, "start" => $jobDraft->startDateTime]);
            return $request->res(['status' => 'success', 'hustlers' => $hustlers]);
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function jobRequests(YPRequest $request): mixed
    {
        return view("crm/hustlers/job-requests");
    }

    public function getHustlerJobRequests(YPRequest $request): mixed
    {
        try {
            $this->hustlerModel = new Hustler();
            $user = auth()->user()->uid;
            $jobRequests = $this->hustlerModel->getHustlerJobRequests(['hustlerId' => $user]);
            return $request->res(['status' => 'success', 'jobRequests' => $jobRequests]);
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}
