<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication; 
use Yohpal\Utils\Util;

class AuthController
{

    public $util;

    public $model;

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->model = new Authentication();
    }

    /**
     * Authenticates a user and returns a success response.
     *
     * If an error occurs during the process, it logs the error and returns a YPException instance error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure.
     */
    public function index(YPRequest $request): mixed
    {
        try {
            if (!isAjaxRequest()) {
                return view('auth/auth');
            }

            $output = null;
            $auth_user_endpoint = $this->util->getEndpoint('auth_user');

            $input = [
                'email' => $request->req('username'),
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
                "user_id" => $user['user']['uid'],
                "user_token" => $user['token']
            ]);

            $userProfile = is_string($profileData) ? json_decode(trim($profileData), true) : $profileData; 

            if (!isset($userProfile['user'])) {
                throw new YPException('An error occurred while trying to log you in, please try again!!!');
            }
            // /GET USER PROFILE

            // GET USER AUTHENTICATED BUSINESS PROFILE
            $get_auth_businesses_endpoint = $this->util->getEndpoint('get_auth_businesses');
            $businessData = $this->model->getBusinessProfileByUid($get_auth_businesses_endpoint, [ 
                "user_id" => $user['user']['uid'],
                "user_token" => $user['token'],
            ]);
            
            $businessData = is_string($businessData) ? json_decode(trim($businessData), true) : $businessData;  

            if (!isset($businessData['stores'])) {
                throw new YPException('An error occurred while trying to log you in, please try again!!!!!!');
            }
            // /GET USER AUTHENTICATED BUSINESS PROFILE

            if (!isset($user['user']) && !isset($userProfile['user']) && !isset($businessData['stores'])) {
                throw new YPException('An error occurred while trying to log you in, please try again!!!!');
            }

            $user['user'] = array_merge($user['user'] ?? [], $userProfile['user'], ['businesses' => $businessData['stores']]);

            $route = '/dashboard';
            if ($user['user']['roleName'] == 'buyer') {
                $route = '/shop';
            }

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
            return $request->res(["status" => 'success', "message" => "Succesfully logged out!"]);
        } catch (\Throwable $th) {
            YPLogger::error($th->getMessage());
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
}
