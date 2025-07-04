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
 * Communication Util, responsible of Communication Utility functions accross authentication module
 * 
 * Right here with YohPal forever!
 */
class CommUtil extends Util
{ 
    private $user;

    private $phone;

    private $email;

    /**
     * Takes care of OTP dissemination.
     * 
     * @return mixed send request response from the API.
     */
    public function sendOtp(array $input): mixed
    {       
        $this->input = $input;
        $this->endpoint = null;

        if (empty($this->input)) {
            throw new YPException('OTP Error. Please try again!'); 
        }

        if (isset($input['phone']) && !empty($input['phone'])) {
            $this->input = ['phone_number' => $input['phone']];
            $this->endpoint = $this->getEndpoint('send_sms');     
        }
        
        if (isset($input['email']) && !empty($input['email'])) {
            $email = $input['email'];
            $profile = auth()->user();
            $otp = $this->generateOtp();
            Auth::create('otp', ['otp' => $otp]);
            $this->input = view('mail/otp-mail', compact('profile', 'email', 'otp'), true);
            $this->endpoint = $this->getEndpoint('send_email');
            
            $this->input = [
                'to' => $email,
                'subject' => 'One-Time Code from Yohpal Hustler App',
                'text' => $this->input
            ];
        }

        $this->user_token = !empty(Auth::get('auth_token')) ? Auth::get('auth_token')->token : null;

        $response = $this->client->post(api_url_parser($this->endpoint->route), [
            'form_params' => $this->input, 
            'headers' => [
                'Accept' => 'application/json',
                "Authorization" => "Bearer $this->user_token"
            ]
        ]);

        $data = $response->getBody()->getContents(); 
        
        $data = is_string($data) ? json_decode(trim($data), true) : $data; 

        if (isset($input['phone']) && !empty($input['phone'])) {
            if (isset($data) && !empty($data['otp'])) {
                Auth::create('otp', ['otp' => $data['otp']]);
            }
    
            if (!isset($data['otp'])) {
                throw new YPException('OTP Error. Please try again!'); 
            }
    
            if (empty($data['otp'])) {
                throw new YPException('OTP Error. Please try again!'); 
            }
        }

        if (isset($input['email']) && !empty($input['email'])) { 
            if (!isset($data['info'])) {
                throw new YPException('OTP Error. Please try again!'); 
            }
    
            if (empty($data['info'])) {
                throw new YPException('OTP Error. Please try again!'); 
            }
        }

        return $data; 
    }
}