<?php

use App\Controllers\Web\AuthController; 

// AUTH Routes
$router->req('GET', '/auth', [AuthController::class, 'index']);
$router->req('POST', '/auth', [AuthController::class, 'index']);
$router->req('POST', '/auth/logout', [AuthController::class, 'logout']);
$router->req('POST', '/auth/forgot-password', [AuthController::class, 'initResetPassord']);
