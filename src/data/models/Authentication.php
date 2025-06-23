<?php

namespace Yohpal\Models;

use Yohpal\Models\Model;
use GuzzleHttp\Client;
use \GuzzleHttp\Exception\RequestException;
use Yohpal\Application\YPLogger;
use Yohpal\Application\Auth;

/**
 * Auth Model
 * 
 * Right here with YohPal forever!
 */
class Authentication extends Model {  
    
    private $user_id; 

    private $input;

    private $credentials; 

    // function methods sits in here!
}