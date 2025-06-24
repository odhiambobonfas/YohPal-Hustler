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
class Authentication extends Model
{

    private $user_id;

    private $input;

    private $credentials;


    /**
     * Authentication starts from here.
     */
    public function authUser(object $endpoint, array $credentials): mixed
    {
        try {
            $this->endpoint = $endpoint;
            $this->credentials = $credentials;
            $response = $this->client->post($this->endpoint->route, [
                'form_params' => $this->credentials,
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = $response->getBody()->getContents();

            return $data;
        } catch (RequestException $error) {
            YPLogger::error($error->getMessage());
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    /**
     * This function takes care of initiating reset password request.
     */
    public function sendResetEmail(object $endpoint, array $input): mixed
    {
        try {
            $this->input = $input;
            $this->endpoint = $endpoint;
            $response = $this->client->post($this->endpoint->route, [
                'form_params' => $this->input,
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = $response->getBody()->getContents();

            return $data;
        } catch (RequestException $error) {
            YPLogger::error($error->getMessage());
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    /**
     * Gets profile for a specified user starts from here.
     */
    public function authUserProfile(object $endpoint, array $input): mixed
    {
        try {
            $this->endpoint = $endpoint; 
            $this->auth_token = $input['user_token'];
            $response = $this->client->get(api_url_parser($this->endpoint->route, $input), [
                'headers' => [
                    'Accept' => 'text/plain',
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $data = $response->getBody()->getContents();

            return $data;
        } catch (RequestException $error) {
            YPLogger::error($error);
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
}
