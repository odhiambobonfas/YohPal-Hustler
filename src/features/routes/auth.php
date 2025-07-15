<?php

use App\Controllers\Web\AuthController; 

// AUTH Routes
$router->req('GET', '/login', [AuthController::class, 'login']);
$router->req('GET', '/register', [AuthController::class, 'signup']); 
$router->req('POST', '/auth/login', [AuthController::class, 'login']);
$router->req('POST', '/auth/signup', [AuthController::class, 'signup']);
$router->req('POST', '/auth/logout', [AuthController::class, 'logout']);
$router->req('GET', '/forgot-password', [AuthController::class, 'initResetPassord']);
$router->req('POST', '/auth/forgot-password', [AuthController::class, 'initResetPassord']);

// OTP verification routes
$router->req('POST', '/otp/verify', [AuthController::class, 'verifyOtp'], [AuthMiddleware::class]);  