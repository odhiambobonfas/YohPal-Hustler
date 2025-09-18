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

    /**
     * Gets the clients dashboard statistics
     */
    public function getDashboardStats(): mixed
    {
        try {
            $endpoint = $this->util->getEndpoint("get_client_dashboard_stats");
            $response = $this->client->get(api_url_parser($endpoint->route, ["userId" => auth()->user()->uid]));
            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);
            $stats = $data["statistics"];
            $allJobs = $stats["allJobs"];
            $openJobs = $stats["openJobs"];
            $ongoingJobs = $stats["ongoingJobs"];
            $cancelledJobs = $stats["cancelledJobs"];
            $rating = $stats["rating"];

            // TODO:: (fd48108cc914) probably move this to its own view instead
            // of stringing it here
            $stats_ui = "
                <div class='stats-card'>
                    <i class='fa-solid fa-business-time s-icon'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$allJobs}</span>
                        <span class='stats-title'>All Jobs</span>
                    </div>
                </div>
                <div class='stats-card'>
                    <i class='fa-solid fa-spinner s-icon' style='color: blue;'></i>
                    <div class='stats-card-row'>
                        <span class='stats-info'>{$ongoingJobs}</span>
                        <span class='stats-title'>Ongoing Jobs</span>
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
