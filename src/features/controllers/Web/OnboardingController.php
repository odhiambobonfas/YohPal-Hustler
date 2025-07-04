<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Utils\Util;
use Yohpal\Utils\CommUtil;

class OnboardingController
{
    public $util;

    public $commUtil;

    public function __construct(Util $util, CommUtil $commUtil)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->commUtil = $commUtil;
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
     * Verify contact phone/email in respect to user fill.
     * 
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function verifyContact(YPRequest $request): mixed
    {
        try {
            $profile = auth()->user();

            $otp_input = $request->req('verificationCode');

            $otpObj = Auth::get('otp'); 
 
            if ($otpObj->otp != $otp_input) {
                throw new YPException('OTP mismatch error!'); 
            }

            return $request->res(['status' => 'success', 'message' => 'Confirmed contact successfully!']);

            throw new YPException("OTP dissemination error. Please try again!");
        } catch (\Throwable $th) {
            YPLogger::error($th); 
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    } 
}
