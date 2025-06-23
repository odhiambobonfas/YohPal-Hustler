<?php

use App\Controllers\Web\AuthController; 

// AUTH Routes
$router->req('POST', '/auth/login', [AuthController::class, 'index']);
$router->req('POST', '/auth/logout', [AuthController::class, 'logout']);
$router->req('POST', '/auth/forgot-password', [AuthController::class, 'initResetPassord']);
