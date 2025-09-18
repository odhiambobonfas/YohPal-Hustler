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
                $hustlers = $data["hustlers"];
                $userId = auth()->user()->uid;

                $filteredHustlers = array_filter($hustlers, function($hustler) use ($userId) {
                    return $hustler['id'] !== $userId;
                });

                return $filteredHustlers;
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

            return [];
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

            return [];
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


            $endpoint = $this->util->getEndpoint('get_hustler_profile');
            $endpoint = api_url_parser($endpoint->route, ["hustlerId" => $user->uid]);
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
    /**
     * @param mixed $input
     * @return array<string,mixed>
     */
    public function getHustlerLiveLocation(array $input): ?array
    {
        try{

            $endpoint = $this->util->getEndpoint("get_hustler_live_location");
            $endpoint = api_url_parser($endpoint->route, $input);
            $response = $this->client->get($endpoint, [
                'headers' => [
                    "Authorization" => "Bearer $this->auth_token"
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (isset($data['location']) && is_array($data['location'])) {
                return $data['location'];
            }

            return $data;
        }catch(RequestException $error) {

            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    public function getDashboardStats(): mixed
    {
        try {
            $endpoint = $this->util->getEndpoint("get_hustler_dashboard_stats");
            $response = $this->client->get(api_url_parser($endpoint->route, ["hustlerId" => auth()->user()->uid]));
            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);
            $stats = $data["statistics"];
            $allJobs = $stats["allJobs"];
            $openJobs = $stats["openJobs"];
            $acceptedJobs = $stats["acceptedJobs"];
            $rejectedJobs = $stats["rejectedJobs"];
            $cancelledJobs = $stats["cancelledJobs"];
            $rating = $stats["rating"];

            // TODO:: (fd48108cc914)
            $stats_ui = "
                <div class='stats-card'>
                    <i class='fa-solid fa-circle-check s-icon' style='color: green;'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$acceptedJobs}</span>
                        <span class='stats-title'>Accepted Jobs</span>
                    </div>
                </div>
                <div class='stats-card'>
                    <i class='fa-solid fa-folder-open s-icon'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$openJobs}</span>
                        <span class='stats-title'>Open Jobs</span>
                    </div>
                </div>
                <div class='stats-card'>
                    <i class='fa-solid fa-ban s-icon' style='color: red;'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$cancelledJobs}</span>
                        <span class='stats-title'>Cancelled Jobs</span>
                    </div>
                </div>
                <div class='stats-card'>
                    <i class='fa-solid fa-xmark s-icon' style='color: orange;'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$rejectedJobs}</span>
                        <span class='stats-title'>Rejected Jobs</span>
                    </div>
                </div>
                <div class='stats-card'>
                    <i class='fa-solid fa-star-half-stroke s-icon' style='color: orange;'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$rating}</span>
                        <span class='stats-title'>Overall Rating</span>
                    </div>
                </div>
            ";

            return $stats_ui;
        } catch(RequestException $error) {
            YPLogger::error($error->getMessage());
            return "<h1>Why you dumb</h1>";
        }
    }

}
