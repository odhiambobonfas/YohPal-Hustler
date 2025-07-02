<?php 

namespace App\Middlewares;

use \Carbon\Carbon;
use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;  

/**
 * Middleware acts as a super utility class, where any middleware can extend it and use its 
 * inner function methods. This class handles the authentication rules logic on the applied 
 * controllers during routes initialization.
 *
 * Right here with YohPal forever!
 */
class Middleware {
    public function __construct() {
        // ANY contructor logic applicable
    }

    /**
     * Check if token has expired or not.
     */
    protected function tokenExpiryDurationConditioner(): bool { 
        $loginTime = auth()->user()->loginTime;

        if (empty($loginTime)) {
            return true;
        }

        $tokenExpiryTime = config('TOKEN_EXPIRY');
    
        try {
            $loginAt = Carbon::createFromFormat('Y-m-d H:i:s', $loginTime);
            return Carbon::now()->greaterThanOrEqualTo($loginAt->copy()->addHours($tokenExpiryTime));
        } catch (\Exception $e) { 
            return true;
        }
    }
}