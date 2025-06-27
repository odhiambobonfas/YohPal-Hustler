<?php

use App\Controllers\Web\DashboardController;
use App\Controllers\Web\JobsController;
use App\Controllers\Web\PaymentController;
use App\Controllers\Web\ProfileController;
use App\Controllers\Web\SettingsController;
use App\Controllers\Web\YohPalController;   
use App\Middlewares\AuthMiddleware;
use Yohpal\Application\YPRouter;

$router = new YPRouter();  

// Define routes 
// web routes
// Landing page routes
$router->req('GET', '/', [YohPalController::class, 'index']);
$router->req('GET', '/index', [YohPalController::class, 'index']); 

// Dashboard Routes
$router->req('GET', '/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]); 
$router->req('GET', '/dashboard/graphical/stats', [PaymentController::class, 'dashboardEarningsData'], [AuthMiddleware::class]); 

// Profile Routes
$router->req('GET', '/profile', [ProfileController::class, 'index'], [AuthMiddleware::class]); 

// Settings Routes
$router->req('GET', '/settings/general', [SettingsController::class, 'generalSettings'], [AuthMiddleware::class]); 
$router->req('GET', '/settings/payment-methods', [SettingsController::class, 'paymentMethods'], [AuthMiddleware::class]); 

// Carreer section routes 
$router->req('GET', '/job-portal', [JobsController::class, 'index'], [AuthMiddleware::class]); 
$router->req('GET', '/portal/jobs/view/[**:path]', [JobsController::class, 'jobsListing'], [AuthMiddleware::class]); 
