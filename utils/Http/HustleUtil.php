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

    /**
     * Takes care of activating hustle client...
     *
     * @return mixed Hustle activation API response.
     */
    public function createHustlerRequest(array $input): mixed
    {
        $this->user = new User();

        $this->input = $input;

        $this->input = [
            'userId' => auth()->user()->uid,
            "name" => auth()->user()->userName ?? auth()->user()->firstName,
            "workBio" => "",

            'pricing' => $input['chargeAmount'],
            'pricingType' => $input['priceUnit'],
            'primaryLocation' => !empty($input['primaryLocation']) ? $input['primaryLocation'] : "Nairobi",
            'primarySkill' => $input['primary_skillset'],
            'skills' => !empty($input['skills']) ? $input['skills'] : null,
            'skillRatings' => [
                'communication' => $input['communication'],
                'competence' => $input['competence'],
                'problem_solving' => $input['problem_solving'],
                'reliability' => $input['reliability'],
                'timeliness' => $input['timeliness'],
            ],
            'cv' => $input['cv'],
            'nationalId' => $input['nationalId'],
            'certifications' => $input['certifications'],
            "images" => $input["images"],
        ];

        $this->user_token = !empty(Auth::get('auth_token')) ? Auth::get('auth_token')->token : null;

        $multipart = [];

        // Create the actual multipart data
        foreach ($this->input as $key => $value) {
            // Handle multiple files
            if (is_array($value) && isset($value[0]['tmp_name'])) {
                foreach ($value as $file) {
                    $multipart[] = [
                        'name' => $key,
                        'contents' => fopen($file['tmp_name'], 'r'),
                        'filename' => $file['name'],
                        'headers' => ['Content-Type' => $file['type']]
                    ];
                }
            }

            // Handle single file
            elseif (is_array($value) && isset($value['tmp_name'])) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => fopen($value['tmp_name'], 'r'),
                    'filename' => $value['name'],
                    'headers' => ['Content-Type' => $value['type']]
                ];
            }

            // Handle scalar or nested array/objects
            else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => is_array($value) ? json_encode($value) : $value
                ];
            }
        }

        $this->endpoint = $this->getEndpoint('create_hustler_request');

        $response = $this->client->post(api_url_parser($this->endpoint->route), [
            'multipart' => $multipart,
            'headers' => [
                'Accept' => 'multipart/form-data',
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
