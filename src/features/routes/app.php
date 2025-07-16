<?php

use App\Controllers\Web\ClientController;
use App\Controllers\Web\ContactsController;
use App\Controllers\Web\DashboardController;
use App\Controllers\Web\HustlersController;
use App\Controllers\Web\JobsController;
use App\Controllers\Web\OnboardingController;
use App\Controllers\Web\PaymentController;
use App\Controllers\Web\ProfileController;
use App\Controllers\Web\SettingsController;
use App\Controllers\Web\UsersController;
use App\Controllers\Web\WebController;
use App\Controllers\Web\YohPalController;   
use App\Middlewares\AuthMiddleware;
use Yohpal\Application\YPRouter;

$router = new YPRouter();  

// Define routes 
// web routes
// Landing page routes
$router->req('GET', '/', [YohPalController::class, 'index']);
$router->req('GET', '/index', [YohPalController::class, 'index']); 

// OTP verification Routes
$router->req('GET', '/contact/verify', [ContactsController::class, 'verifyContact'], [AuthMiddleware::class]); 
$router->req('POST', '/contact/verify', [ContactsController::class, 'verifyContact'], [AuthMiddleware::class]); 

// Dashboard Routes
$router->req('GET', '/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]); 
$router->req('GET', '/dashboard-ui', [DashboardController::class, 'ui'], [AuthMiddleware::class]); 
$router->req('GET', '/hustlers-ui', [DashboardController::class, 'hustlers_ui'], [AuthMiddleware::class]); 
$router->req('GET', '/users/count/stats', [UsersController::class, 'usersCount'], [AuthMiddleware::class]); 
$router->req('GET', '/dashboard/graphical/stats', [PaymentController::class, 'dashboardEarningsData'], [AuthMiddleware::class]); 

// Profile Routes
$router->req('GET', '/profile', [ProfileController::class, 'index'], [AuthMiddleware::class]); 

// Carreer section routes 
$router->req('GET', '/job-portal', [JobsController::class, 'index'], [AuthMiddleware::class]); 
$router->req('GET', '/portal/jobs/view/[**:path]', [JobsController::class, 'jobsListing'], [AuthMiddleware::class]); 

// Onboarding routes
$router->req('POST', '/job/create/[**:path]', [JobsController::class, 'createJobDraft'], [AuthMiddleware::class]); 
$router->req('GET', '/onboarding', [OnboardingController::class, 'index'], [AuthMiddleware::class]); 
$router->req('POST', '/profile/update', [OnboardingController::class, 'updateProfileDetails'], [AuthMiddleware::class]);  

// Account routes
$router->req('POST', '/account/activate-account', [OnboardingController::class, 'activateAccount'], [AuthMiddleware::class]);  

// Get started web routes
$router->req('GET', '/get-started', [WebController::class, 'getStarted'], [AuthMiddleware::class]);  
$router->req('POST', '/get-started/onboarding', [WebController::class, 'getStarted'], [AuthMiddleware::class]);  
$router->req('GET', '/search-engine', [WebController::class, 'searchEngine'], [AuthMiddleware::class]);  
$router->req('GET', '/users/hustlers', [HustlersController::class, 'getActiveHustlersByPrimarySkill'], [AuthMiddleware::class]);

// Client related routes
$router->req("GET", "/crm/client-activities", [ClientController::class, "clientActivities"], [AuthMiddleware::class]);
