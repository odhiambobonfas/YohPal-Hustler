<?php

namespace Yohpal\Models;

use GuzzleHttp\Exception\RequestException;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Models\Model;

/**
 * Hustlers Model
 *
 * Right here with YohPal forever!
 */
class Hustler extends Model
{


    /**
     * Fetches and returns the active hustlers from the hustlers db resource
     *
     * @return array
     * @param array<int,mixed> $input
     */
    public function getActiveHustlersByPrimarySkill(array $input): array
    {
        try {
            $job = Auth::get("newJob");
            $base="https://yohpal-hustler-apis-test.onrender.com";

            $endpoint = $base."/jobs/get_active_hustlers/".$job->name."?start=".$job->startDateTime;
            $response = $this->client->get($endpoint, [
                'headers' => [
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
                "job" => $job,
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
    /**
     * @param array<int,mixed> $input
     * @return mixed|array<string,mixed>
     */
    public function getHustlerJobRequests(array $input): array
    {
        try {
            $endpoint = $this->util->getEndpoint('get_hustler_job_request');
            $response = $this->client->get(api_url_parser($endpoint->route, $input), [
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (isset($data['jobRequests']) && is_array($data['jobRequests'])) {
                return $data['jobRequests'];
            }

            return $data;
        } catch (RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }


    /**
     * @param array<int,mixed> $input
     * @return mixed|array<string,mixed>
     */
    public function getHustlerJobHistory(array $input): array
    {
        try {
            $endpoint = $this->util->getEndpoint('get_hustler_job_history');
            $response = $this->client->get(api_url_parser($endpoint->route, $input), [
                'headers' => [
                    "Accept" => "application/json",
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
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    /**
     * @return null|array<string,mixed>
     */
    public function getHustlerProfile(): ?array
    {
        try {
            $user = auth()->user();
            $hustler = auth()->hustler();
            // return early
            if (isset($hustler) && is_array($hustler)) return null;

            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/profile/$user->uid";
            $response = $this->client->get($endpoint, [
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (isset($data['profile']) && is_array($data['profile'])) {
                Auth::create("hustler", $data["profile"]);
            }
            return null;

        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
    /**
     * @param mixed $input
     */
    public function updateProfile($input): ?array
    {
        try {
            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/profile/edit";
            $response = $this->client->put($endpoint, [
                "json" => $input,
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);
            return null;
        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    /**
     * @param mixed $input
     */
    public function updatePrimaryLocation($input): ?array
    {
        try {
            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/location/update_primary";
            $response = $this->client->post($endpoint, [
                "json" => $input,
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);
            return null;
        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    /**
     * @param mixed $input
     */
    public function updateAvailability($input): ?array
    {
        try {
            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/availability/update";
            $response = $this->client->post($endpoint, [
                "json" => $input,
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);
            return null;
        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
    /**
     * @param mixed $input
     */
    public function updatePrimarySkill($input): ?array
    {
        try {
            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/profile/edit/primary_skill";
            $response = $this->client->put($endpoint, [
                "json" => $input,
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);
            return null;
        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
    /**
     * @param mixed $input
     */
    public function updateSkills($input): ?array
    {
        try {
            $endpoint = "https://yohpal-hustler-apis-test.onrender.com/hustler/profile/edit/skills";
            $response = $this->client->put($endpoint, [
                "json" => $input,
                'headers' => [
                    "Accept" => "application/json",
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);
            return null;
        } catch(RequestException $error) {
            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

}
