<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Application\Auth;
use Yohpal\Application\YPLogger;
use Yohpal\Application\YPException;
use Yohpal\Models\Model;
use Yohpal\Models\Authentication;
use Yohpal\Models\Category;
use Yohpal\Models\Job;
use Yohpal\Models\Payment;
use Yohpal\Utils\Util;

class AdminController
{
    public $util;

    public $model;

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
        $this->util = $util;
        $this->model = new Authentication();
    }

    public function index(YPRequest $request): mixed{
        return view('Admin/admin');
    }
}
