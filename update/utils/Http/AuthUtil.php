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
 * Auth Util, responsible of Auth Utility functions accross authentication module
 * 
 * Right here with YohPal forever!
 */
class AuthUtil extends Util
{ 
    private $user;

    /**
     * Takes care of auth registration.
     * 
     * @return mixed Registration response from the API.
     */
    public function registerUser(array $input): mixed
    { 
        $this->user = new User();

        $this->input = $input;

        $this->user_token = !empty(Auth::get('auth_token')) ? Auth::get('auth_token')->token : null;

        $this->endpoint = $this->getEndpoint('auth_register_endpoint'); 

        $response = $this->client->post(api_url_parser($this->endpoint->route), [
            'form_params' => $this->input, 
            'headers' => [
                'Accept' => 'application/json',
                "Authorization" => "Bearer $this->user_token"
            ]
        ]);

        $data = $response->getBody()->getContents(); 
        
        $data = is_string($data) ? json_decode(trim($data), true) : $data;  

        return $data;
    }
}
