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

class ContactsController
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
     * Verify the contacts in respect to user in session/onboarding.
     * 
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function verifyContact(YPRequest $request): mixed
    {
        try {
            if (!isAjaxRequest()) {
                $authRole = !empty(auth()->user()) ? auth()->user()->role : null;
                return view('crm/contacts/confirm', compact('authRole'));
            }

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

                return $request->res(['status' => 'success', 'modal_body' => view('auth/verify-email', compact('profile'), true)]);
            }

            if (preg_match('/^\+?[0-9]{7,15}$/', $contactInput)) {
                $res = $this->commUtil->sendOtp(['phone' => $contactInput]);

                if (!$res) {
                    throw new YPException('An OTP dissemination error occurred. Please try again!');
                }

                return $request->res(['status' => 'success', 'modal_body' => view('auth/verify-phone', compact('profile'), true)]);
            }

            throw new YPException("OTP dissemination error. Please try again!");
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}