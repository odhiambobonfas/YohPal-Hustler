<?php

namespace Yohpal\Models;

use Yohpal\Application\YPLogger;
use GuzzleHttp\Exception\RequestException;
use Yohpal\Models\Model;
use Yohpal\Application\Auth;

/**
 * Client Model
 *
 * Right here with YohPal forever!
 */
class Client extends Model
{


    /**
     * Fetches and returns the clients job activities
     *
     * @return array
     * @param array<int,mixed> $input
     */
    public function getJobHistory(array $input): array
    {
        try {
            $endpoint = $this->util->getEndpoint('get_client_job_history');
            $response = $this->client->get(api_url_parser($endpoint->route, $input), [
                'headers' => [
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (isset($data['jobHistory']) && is_array($data['jobHistory'])) {
                return $data['jobHistory'];
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
