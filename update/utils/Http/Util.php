<?php

namespace Yohpal\Utils;

use Yohpal\Application\YPLogger;
use Yohpal\Application\Auth;
use Yohpal\Models\Model;
use GuzzleHttp\Client;
use \Exception;
use Yohpal\Application\YPException;

/**
 * Util class acts as the Base Utility. A bridge to other utils if need be. 
 * 
 * A cleaner approach to utility structure.
 * Right here with YohPal forever!
 */
class Util
{

    protected $client;

    protected $input;

    protected $endpoint;

    protected $user_token;

    public function __construct()
    {
        // ANY LOGIC APPLICABLE 
        $this->client = new Client([
            'debug' => env('API_DEBUG', false)
        ]);
    }

    /**
     * Gets an endpoint from the endpoint bindings using a param key
     */
    public function getEndpoint(string $key): object|null
    {
        $endpoints = binding('endpoints');
        $endpoint = isset($endpoints[$key]) ? (object)$endpoints[$key] : null;

        if (empty($endpoint)) {
            throw new YPException("Oops, Your request has been denied!", 404);
        }

        return $endpoint;
    }

    /**
     * Takes care of OTP generation and return as an int number
     */
    public function generateOtp(): int
    {
        $timestamp = time();
        $secret = config('APP_SECRET') ?? null; 
        if (!$secret) {
            $secret = bin2hex(random_bytes(16));
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'default-agent'; 
        $hash = hash_hmac('sha256', $timestamp . $userAgent, $secret); 
        $numericString = preg_replace('/[^0-9]/', '', base_convert(substr($hash, 0, 16), 16, 10));

        $otp = substr(str_pad($numericString, 6, '0', STR_PAD_RIGHT), 0, 6);

        return (int) $otp;
    }
}
