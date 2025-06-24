<?php

use App\Controllers\Web\AuthController; 

// AUTH Routes
$router->req('GET', '/auth', [AuthController::class, 'index']);
$router->req('POST', '/auth/login', [AuthController::class, 'index']);
$router->req('POST', '/auth/logout', [AuthController::class, 'logout']);
$router->req('GET', '/forgot-password', [AuthController::class, 'initResetPassord']);
$router->req('POST', '/auth/forgot-password', [AuthController::class, 'initResetPassord']);
