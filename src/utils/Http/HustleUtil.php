<?php

namespace Yohpal\Utils;

use Yohpal\Application\YPLogger;
use Yohpal\Application\Auth;
use Yohpal\Models\Model;
use Yohpal\Models\User;
use GuzzleHttp\Client;
use \Exception;
use Yohpal\Application\YPException;

/**
 * Hustle Util, responsible of Hustle Utility functions accross authentication module
 * 
 * Right here with YohPal forever!
 */
class HustleUtil extends Util
{ 
    private $user; 

    /**
     * Takes care of activating hustle client...
     * 
     * @return mixed Hustle activation API response.
     */
    public function activateHustleClient(array $input): mixed
    { 
        $this->user = new User();

        $this->input = $input;

        $this->user_token = !empty(Auth::get('auth_token')) ? Auth::get('auth_token')->token : null;

        $this->endpoint = $this->getEndpoint('activate_client'); 

        $response = $this->client->put(api_url_parser($this->endpoint->route), [
            'form_params' => $this->input, 
            'headers' => [
                'Accept' => 'application/json',
                "Authorization" => "Bearer $this->user_token"
            ]
        ]);

        $statusCode = $response->getStatusCode();

        $data = $response->getBody()->getContents(); 
        
        $data = is_string($data) ? json_decode(trim($data), true) : $data;  
        
        $data['code'] = $statusCode; 

        return $data;
    }
}
