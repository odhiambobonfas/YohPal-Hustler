<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication;
use Yohpal\Utils\Util;
use Yohpal\Utils\CommUtil;
use Yohpal\Utils\HustleUtil;

class OnboardingController
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

    /**
     * Returns the onboarding page view to the user
     * 
     * @return view The home page.
     */
    public function index(YPRequest $request): mixed
    {
        try {
            $profile = auth()->user();
            return $request->res(['status' => 'success', 'modal_body' => view('onboarding/index', compact('profile'), true)]);
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * Updates the profile details in respect to user fills.
     * 
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function updateProfileDetails(YPRequest $request): mixed
    {
        try {
            return $request->res(['status' => 'success', 'message' => 'Profile Updated Successfully']);
        } catch (YPException $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * This function takes care of account activation and unlocking the portal for access.
     * 
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function activateAccount(YPRequest $request): mixed {
        try {
            $input = $request->req();  
            
            $chargeAmount = $request->req('chargeAmount');

            $primaryLocation = null;
            
            $skills = [];
            
            $input['cv'] = $request->req('cv');

            $input['portfolio'] = $request->req('portfolio');
            
            $input['nationalId'] = array_merge($request->req('nid_front'), $request->req('nid_back'));

            $input['certifications'] = $request->req('certificates');

            $req = $this->hustleUtil->createHustlerRequest($input);

            if (!$req) {
                throw new YPRequest("An error occurred while trying to activate your account!");
            }

            $profile = auth()->user();

            $statusUpdate = $this->hustleUtil->activateHustleClient([
                'userId' => $profile->uid
            ]);

            if (isset($statusUpdate['code']) && $statusUpdate['code'] != 200) {
                throw new YPException('Oops, an error occurred while trying to unlock your hustle account!');
            }

            if(isset($statusUpdate['code'])) {
                // GET USER PROFILE
                $this->model = new Authentication();
                $auth_profile_endpoint = $this->util->getEndpoint('get_user_profile');

                $profileData = $this->model->authUserProfile($auth_profile_endpoint, [
                    "uid" => $profile->uid,
                    "user_token" => !empty(Auth::get('auth_token')) ? Auth::get('auth_token')->token : null
                ]);

                $userProfile = is_string($profileData) ? json_decode(trim($profileData), true) : $profileData; 
                
                if (!isset($userProfile['user'])) {
                    throw new YPException('An error occurred while trying to log you in, please try again!!!');
                }  
                
                $user['user'] = array_merge((array)$profile ?? [], $userProfile['user']);

                Auth::create('auth', $user['user']);
                // GET USER PROFILE
            }

            return $request->res(['status' => 'success', 'input' => $chargeAmount]);
        } catch (YPException $th) {
            YPLogger::error($th); 
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}
