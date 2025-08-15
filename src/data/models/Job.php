<?php

namespace Yohpal\Models;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Utils;
use Yohpal\Models\Model;

/**
 * Jobs Model
 *
 * Right here with YohPal forever!
 */
class Job extends Model {


    /**
     * Gives out the static job skill sets
     *
     * @return array
     */
    public static function skillsets(): array
    {
        $skillsets = [
            'OIUHJDJHDJMNHDN' => 'Accountant',
            'MUDJEKNDMNBDJDD' => 'Plumber',
            'MBUHFBUFKJJDKJD' => 'Photography',
            'UKHOKLJHGHJNDFH' => 'Marketing',
            'KDYDHDJMDLDMJCN' => 'Software Engineering'
        ];

        return $skillsets;
    }

    /**
     * Generates HTML <option> elements from job skillsets array.
     *
     * @return string HTML string for <select> options
     */
    public static function skillsetDropdownOptions(): string
    {
        $skillsets = self::skillsets();

        $options = '<option value="">-- Skill set, eg. Plumber --</option>';
        foreach ($skillsets as $key => $set) {
            $options .= '<option value="' . $key . '">' . htmlspecialchars($set) . '</option>';
        }

        return $options;
    }
    /**
     * @param mixed $jobDetails
     * @return null|array<string,mixed>
     */
    public function createJob($jobDetails): ?array {

        try {
            $user = auth()->user();

            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/jobs/create";

            $response = $this->client->post($endpoint, [
                "json" => $jobDetails,
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            return [
                "json"=>$json,
                "message" => $data->message,
                "jobsDetails" => $jobDetails,
            ];
        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }

    }
    /**
     * @param mixed $details
     * @return array<string,mixed>
     */
    public function acceptJob($details): array  {
        $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/accept_request";

        $response = $this->client->put($endpoint, [
            "json" => $details,
            'headers' => [
                "Accept" => "application/json",
                "Authorization" => "Bearer $this->auth_token"
            ]
        ]);

        $json = $response->getBody()->getContents();
        $data = json_decode($json, true);

        return [
            "json"=>$json,
            "data" => $data,
            "message" => $data->message,
        ];

    }
    /**
     * @param mixed $details
     */
    public function rejectJob($details): array {

        $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/reject_request";

        $response = $this->client->put($endpoint, [
            "json" => $details,
            'headers' => [
                "Accept" => "application/json",
                "Authorization" => "Bearer $this->auth_token"
            ]
        ]);

        $json = $response->getBody()->getContents();
        $data = json_decode($json, true);

        return [
            "json"=>$json,
            "message" => $data->message,
        ];
    }

    /**
     * @param mixed $jobId
     */
    public function getJobDetails($jobId): array {

        try{
            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/jobs/get_details/".$jobId;
            $response = $this->client->get($endpoint, [
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            return [
                "json"=> $json,
                "message" => $data->message,
                "data" => $data,
            ];
        } catch(RequestException $error) {
            return [
                "error" => true,
                "message" => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
}
