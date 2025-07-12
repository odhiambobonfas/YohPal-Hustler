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

    public function __construct(Util $util, CommUtil $commUtil, HustleUtil $hustleUtil)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->commUtil = $commUtil;
        $this->hustleUtil = $hustleUtil;
    }

    public function getActiveHustlersByPrimarySkill(YPRequest $request): mixed {
        try {
            $this->hustlerModel = new Hustler();
            $jobDraft = Auth::get('newJob'); 
            $hustlers = $this->hustlerModel->getActiveHustlersByPrimarySkill(['primarySkill' => $jobDraft->name]);
            return $request->res(['status' => 'success', 'hustlers' => $hustlers]);
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}