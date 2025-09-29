<?php

namespace Yohpal\Models;

use GuzzleHttp\Client;
use Yohpal\Utils\Util;

/**
 * Model class acts as the Base class model. A bridge to other models if need be. 
 * 
 * A cleaner approach to modelling structure.
 * Right here with YohPal forever!
 */
class Model
{

    protected $util;
    
    protected $client;

    protected $endpoint;

    protected $auth_token;

    public function __construct()
    {
        $this->client = new Client([
            'debug' => env('API_DEBUG', false)
        ]);

        $this->util = new Util();
    }
}
