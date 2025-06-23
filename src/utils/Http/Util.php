<?php

namespace Yohpal\Utils;

use Yohpal\Application\YPLogger;
use Yohpal\Application\Auth;
use Yohpal\Models\Model; 
use GuzzleHttp\Client;
use \Exception;
use Yohpal\Application\YPException;

/**
 * Util class acts as the Base Utility. A bridge to other utils if need be. 
 * 
 * A cleaner approach to utility structure.
 * Right here with YohPal forever!
 */
class Util {

    protected $client;

    protected $endpoint; 

    public function __construct() {
        // ANY LOGIC APPLICABLE 
        $this->client = new Client([
            'debug' => env('API_DEBUG', false)
        ]);
    }
}