<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication; 
use Yohpal\Utils\Util;
use Yohpal\Utils\AuthUtil;
use Yohpal\Utils\HustleUtil;

class AuthController
{

    public $util;

    public $authUtil;

    public $model;

    public $hustleUtil;

    public function __construct(Util $util, AuthUtil $authUtil, HustleUtil $hustleUtil)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->authUtil = $authUtil;
        $this->model = new Authentication();
        $this->hustleUtil = $hustleUtil;
    }

    /**
     * Authenticates a user by signing in and returns a success response OR renders a sign in html view.
     *
     * If an error occurs during the process, it logs the error and returns a YPException instance error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure OR a html view render.
     */
    public function login(YPRequest $request): mixed
    {
        try {
            if (!isAjaxRequest()) {
                return view('auth/login');
            }

            $output = null;
            $auth_user_endpoint = $this->util->getEndpoint('auth_user');

            $input = [
                'email' => $request->req('email'),
                'password' => $request->req('password')
            ]; 

            // AUTHENTICATE USER
            $userData = $this->model->authUser($auth_user_endpoint, $input);

            $user =  is_string($userData) ? json_decode(trim($userData), true) : $userData;  

            if (!isset($user['user'])) {
                throw new YPException('An error occurred while trying to log you in, please try again!!');
            }

            Auth::create('auth_token', ['token' => $user['token']]);
            // /AUTHENTICATE USER

            // GET USER PROFILE
            $auth_profile_endpoint = $this->util->getEndpoint('get_user_profile');

            $profileData = $this->model->authUserProfile($auth_profile_endpoint, [
                "uid" => $user['user']['uid'],
                "user_token" => $user['token']
            ]);

            $userProfile = is_string($profileData) ? json_decode(trim($profileData), true) : $profileData; 
            
            if (!isset($userProfile['user'])) {
                throw new YPException('An error occurred while trying to log you in, please try again!!!');
            }
            // /GET USER PROFILE 

            if (!isset($user['user']) && !isset($userProfile['user'])) {
                throw new YPException('An error occurred while trying to log you in, please try again!!!!');
            }

            $user['user'] = array_merge($user['user'] ?? [], $userProfile['user']); 
            
            $role = Auth::get('role');
            $user['user']['role'] = empty($role) ? 'client' : (!empty($role->role) ? strtolower($role->role) : null);

            $route = !empty(auth()->user()) && isset(auth()->user()->clientHustleStatus) && auth()->user()->clientHustleStatus == 'active' ? '/dashboard' : '/contact/verify';

            $user['user']['loginTime'] = date("Y-m-d H:i:s");

            // initialize/set session
            Auth::create('auth', $user['user']);
            
            return $request->res(["status" => 'success', "message" => "Succesfully logged in!", 'route' => $route, 'user' => $user, 'profileData' => $profileData]);
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * Authenticates a user by signing up and returns a success response OR renders a signup html view.
     *
     * If an error occurs during the process, it logs the error and returns a YPException instance error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure OR a html view render.
     */
    public function signup(YPRequest $request):mixed {
        try { 
            if (!isAjaxRequest()) {
                return view('auth/register');
            }

            $password = $request->req('password1');
            $confirmPassword = $request->req('password2');

            if ($password !== $confirmPassword) {
                throw new Exception('Password mismatch error occurred. Please confirm password to continue!'); 
            }

            $input = [
                'email' => $request->req('email'),
                'password' => $request->req('password1')
            ]; 

            $req = $this->authUtil->registerUser($input);

            $req =  is_string($req) ? json_decode(trim($req), true) : $req; 

            if (!$req) {
                throw new YPException('An error occurred while trying to finalize registration, please try again!!');
            }

            return $request->res(["status" => 'success', "message" => "Registered successfully. Please go to login page to proceed with logging in!", 'req' => $req]);

        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * Initializes a reset password request, & returns a success response.
     *
     * If an error occurs during request, it logs the error and returns a generic error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function initResetPassord(YPRequest $request) {
        try { 
            if (!isAjaxRequest()) {
                return view('auth/forgot-pass');
            }

            $input = ['email' => $request->req('email')]; 
            $fp_endpoint = $this->util->getEndpoint('auth_forgot_password');
            $req = $this->model->sendResetEmail($fp_endpoint, $input);

            $req =  is_string($req) ? json_decode(trim($req), true) : $req; 

            if (!$req) {
                throw new YPException('An error occurred while trying initiate your password reset request, please try again!!');
            }

            return $request->res(["status" => 'success', "message" => "Succesfully sent password reset link to the provided email address!", 'req' => $req]);

        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    } 

    /**
     * Logs out the currently authenticated user and returns a success response.
     *
     * If an error occurs during logout, it logs the error and returns a generic error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function logout(YPRequest $request): mixed
    {
        try {
            Auth::logout();
            return $request->res(["status" => 'success', "message" => "Succesfully logged out!", "route" => "login"]);
        } catch (\Throwable $th) {
            YPLogger::error($th->getMessage());
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

            $route = $client ? '/dashboard' : null;

            return $request->res(['status' => 'success', 'message' => 'Confirmed contact successfully!', 'client' => $client, 'route' => $route]);

            throw new YPException("OTP dissemination error. Please try again!");
        } catch (\Throwable $th) {
            YPLogger::error($th); 
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    } 
}
