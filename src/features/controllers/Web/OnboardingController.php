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
        } catch (\Throwable $th) {
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
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * Verify the profile details in respect to user in session/onboarding.
     * 
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function verifyProfileDetails(YPRequest $request): mixed
    {
        try {
            $profile = auth()->user(); 
            $contactInput = $request->req('contact');

            if (empty($contactInput)) {
                throw new YPException("Contact not found. Please fill in correct email or phone number!"); 
            }

            if (filter_var($contactInput, FILTER_VALIDATE_EMAIL)) {
                $res = $this->commUtil->sendOtp(['email' => $contactInput]);

                if (!$res) {
                    throw new YPException('An OTP dissemination error occurred. Please try again!');
                }

                return $request->res(['status' => 'success', 'modal_body' => view('dashboard/onboarding/verify-email', compact('profile'), true)]);
            }

            if (preg_match('/^\+?[0-9]{7,15}$/', $contactInput)) {
                $res = $this->commUtil->sendOtp(['phone' => $contactInput]);

                if (!$res) {
                    throw new YPException('An OTP dissemination error occurred. Please try again!');
                }

                return $request->res(['status' => 'success', 'modal_body' => view('dashboard/onboarding/verify-phone', compact('profile'), true)]);
            }

            throw new YPException("OTP dissemination error. Please try again!");
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * Verify contact phone/email in respect to user fill OTP.
     * 
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function verifyOTP(YPRequest $request): mixed
    {
        try {
            $profile = auth()->user();

            $otp_array = $request->req('verificationCode');

            if (empty($otp_array)) {
                throw new YPException('OTP appears empty. Please try again!');
            }

            $otp_input = is_array($otp_array) ? implode('', $otp_array) : null;
            
            if (!preg_match('/^\d{6}$/', $otp_input)) {
                throw new YPException('OTP appears invalid. Please try again!');
            }

            $otpObj = Auth::get('otp'); 
 
            if ($otpObj->otp != $otp_input) {
                throw new YPException('OTP mismatch error!'); 
            }

            $client = isset($profile->role) && $profile->role == 'client' ? true : false;

            // if the user is a client, proceed to updating client's account hustle status
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

            return $request->res(['status' => 'success', 'message' => 'Confirmed contact successfully!', 'client' => $client]);

            throw new YPException("OTP dissemination error. Please try again!");
        } catch (\Throwable $th) {
            YPLogger::error($th); 
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    } 
}
