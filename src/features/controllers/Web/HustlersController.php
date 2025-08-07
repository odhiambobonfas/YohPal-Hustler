<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Category;
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
        $pricingUnits = Category::pricingUnits();
        $services = Category::hustleCategoriesDropdownOptions();
        $response = $this->hustler->getHustlerProfile();
        return view("crm/hustlers/profile", compact("pricingUnits", "services"));
    }

    public function getActiveHustlersByPrimarySkill(YPRequest $request): mixed
    {
        try {
            $jobDraft = Auth::get('newJob');
            $hustlers = $this->hustler->getActiveHustlersByPrimarySkill(['primarySkill' => $jobDraft->name, "start" => $jobDraft->startDateTime]);
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
            $user = auth()->user()->uid;
            $jobRequests = $this->hustler->getHustlerJobRequests(['hustlerId' => $user]);
            return $request->res(['status' => 'success', 'jobRequests' => $jobRequests]);
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    public function updateProfile(YPRequest $request): mixed
    {
        try {
            $input = $request->req();
            $hustlerId = Auth::user()->uid;

            $profilePayload = [
                "hustlerId"   => $hustlerId,
                "pricing"     => $input["pricing"],
                "pricingType" => $input["pricingType"],
                "workBio"     => $input["workBio"],
            ];

            $skillsPayload = [
                "hustlerId" => $hustlerId,
                "skills"    => explode(",", $input["skills"]),
            ];

            $primarySkillPayload = [
                "hustlerId"    => $hustlerId,
                "primarySkill" => $input["primarySkill"],
            ];

            $availabilityPayload = [
                "hustlerId" => $hustlerId,
                "type"      => "partial",
                "days"      => array_keys($input["availability"], 1),
            ];

            $primaryLocationPayload = [
                "uid" => $hustlerId,
                "location" => $input["primaryLocation"],
            ];

            $this->hustler->updateProfile($profilePayload);
            $this->hustler->updatePrimaryLocation($primaryLocationPayload);
            $this->hustler->updateAvailability($availabilityPayload);
            $this->hustler->updateSkills($skillsPayload);
            $this->hustler->updatePrimarySkill($primarySkillPayload);

            // get the hustler's updated details
            $this->hustler->getHustlerProfile();

            return $request->res(["status" => "success",
                "data" => $input,
                "location" => $primaryLocationPayload,
                "avail" => $availabilityPayload,
                "skills" => $skillsPayload,
                "primarySkill" => $primarySkillPayload,
                "profile" => $profilePayload,
            ]);
        } catch(YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}
