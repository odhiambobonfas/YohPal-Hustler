<?php

use App\Controllers\Web\ContactsController;
use App\Controllers\Web\DashboardController;
use App\Controllers\Web\JobsController;
use App\Controllers\Web\OnboardingController;
use App\Controllers\Web\PaymentController;
use App\Controllers\Web\ProfileController;
use App\Controllers\Web\SettingsController;
use App\Controllers\Web\UsersController;
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
$router->req('GET', '/contact/verify', [ContactsController::class, 'verifyContact']); 
$router->req('POST', '/contact/verify', [ContactsController::class, 'verifyContact']); 

// Dashboard Routes
$router->req('GET', '/dashboard', [DashboardController::class, 'index']); 
$router->req('GET', '/dashboard-ui', [DashboardController::class, 'ui']); 
$router->req('GET', '/hustlers-ui', [DashboardController::class, 'hustlers_ui']); 
$router->req('GET', '/users/count/stats', [UsersController::class, 'usersCount']); 
$router->req('GET', '/dashboard/graphical/stats', [PaymentController::class, 'dashboardEarningsData']); 

// Profile Routes
$router->req('GET', '/profile', [ProfileController::class, 'index']); 

// Carreer section routes 
$router->req('GET', '/job-portal', [JobsController::class, 'index']); 
$router->req('GET', '/portal/jobs/view/[**:path]', [JobsController::class, 'jobsListing']); 

// Onboarding routes
$router->req('POST', '/job/create/[**:path]', [JobsController::class, 'createJobDraft']); 
$router->req('GET', '/onboarding', [OnboardingController::class, 'index']); 
$router->req('POST', '/profile/update', [OnboardingController::class, 'updateProfileDetails']);  

// Account routes
$router->req('POST', '/account/activate-account', [OnboardingController::class, 'activateAccount']);  
