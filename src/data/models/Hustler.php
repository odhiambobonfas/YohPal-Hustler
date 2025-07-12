<?php

namespace Yohpal\Models;

use Yohpal\Models\Model;
use Yohpal\Application\Auth;

/**
 * Hustlers Model
 * 
 * Right here with YohPal forever!
 */
class Hustler extends Model { 
    
    
    /**
     * Fetches and returns the active hustlers from the hustlers db resource
     *
     * @return array
     */
    public function getActiveHustlersByPrimarySkill(array $input): array
    {
        try { 
            $endpoint = $this->util->getEndpoint('get_active_hustlers');
            $response = $this->client->get(api_url_parser($endpoint->route, $input), [
                'headers' => [
                    'Accept' => 'application/json',
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (isset($data['hustlers']) && is_array($data['hustlers'])) {
                return $data['hustlers'];
            }

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
}