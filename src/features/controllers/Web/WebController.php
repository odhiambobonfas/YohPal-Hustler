<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication;
use Yohpal\Utils\Util;
use Yohpal\Utils\CommUtil;
use Yohpal\Utils\HustleUtil;

class WebController
{
    public $model;

    public $util;

    public $commUtil;

    public $hustleUtil;

    public function __construct(Util $util, CommUtil $commUtil, HustleUtil $hustleUtil)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->commUtil = $commUtil;
        $this->hustleUtil = $hustleUtil;
    }

    /**
     * Get started with onboarding...
     * If an error occurs during the process, it logs the error and returns a YPException instance error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure OR a html view render.
     */
    public function getStarted(YPRequest $request): mixed {
        try {
            if (isAjaxRequest()) { 
                $clientRole = $request->req('clientRole');
                $hustlerRole = $request->req('hustlerRole'); 
                Auth::create('role', ['role' => $clientRole ?? $hustlerRole]); 
                $route = '/search-engine';
                return $request->res(['status' => 'success', 'route' => $route]);
            }

            return view('web/get-started');
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }

    /**
     * Perfom search engine activities, search skills, jobs dependant on the role selected from the onboarding view
     * If an error occurs during the process, it logs the error and returns a YPException instance error message.
     *
     * @param YPRequest $request The request instance containing the custom response method.
     * @return mixed A JSON-formatted response instigating whether it is a success or failure OR a html view render.
     */
    public function searchEngine(YPRequest $request): mixed {
        try { 
            $authRole = !empty(Auth::get('role')) && isset(Auth::get('role')->role) ? strtolower(Auth::get('role')->role) : null;
            return view('web/search-engine', compact('authRole'));
        } catch (\Throwable $th) {
            YPLogger::error($th);
            return $request->res(["status" => 'error', "message" => ypLog($th, "An error occurred. Please try again!")]);
        }
    }
    
}