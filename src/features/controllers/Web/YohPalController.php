<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Models\Model; 
use Yohpal\Utils\Util;

class YohPalController
{

    public $util; 

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util; 
    }

    /**
     * Returns the home page view to the user
     * 
     * @return view The home page.
     */
    public function index(YPRequest $req)
    { 
        return view('index');
    }
    
}
