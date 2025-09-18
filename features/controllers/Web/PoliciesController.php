<?php

namespace App\Controllers\Web;

use Yohpal\Application\YPRequest;
use Yohpal\Models\Authentication;
use Yohpal\Utils\Util;

class PoliciesController
{
    public $util;

    public $model;

    public function __construct(Util $util)
    {
        // ANY APPLICABLE LOGIC
    }

    public function hustlerTerms(YPRequest $request): mixed{
        return view('web/policies/hustlerTerms');
    }

    public function clientTerms(YPRequest $request): mixed{
        return view('web/policies/clientTerms');
    }

    public function privacyPolicy(YPRequest $request): mixed{
        return view('web/policies/privacyPolicy');
    }
}
