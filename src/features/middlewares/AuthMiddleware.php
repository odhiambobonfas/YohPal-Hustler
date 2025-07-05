<?php 

namespace App\Middlewares;

use App\Middlewares\Middleware;
use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;  

/**
 * Auth Middleware is a cleaner approach to Authentication check binding.
 * This class handles the authentication rules logic on the applied controllers during routes initialization.
 * It initializes Auth checks by ensuring correct authentication is employed accordingly.
 *
 * Right here with YohPal forever!
 */
class AuthMiddleware extends Middleware {

    /**
     * Handle authentication check for the request 
     * 
     * @return mixed
     * @throws YPException
     */
    public function handle()
    {
        try {
            if (!auth()->user()) {
                throw new YPException('Unauthorized access. Login required.', 401);
            } 

            if ($this->tokenExpiryDurationConditioner()) {
                throw new YPException('Authorization access expired. Login required.', 401);
            }
    
            return true;
        } catch (\Throwable $th) {
            Auth::logout();
            header('Location: /login');
            return view('auth/login', ['message' => ypLog($th, 'You have been booted out. Please login again!')]);
        }
    }

}