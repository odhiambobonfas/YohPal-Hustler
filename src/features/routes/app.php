<?php 

use App\Controllers\Web\YohPalController;   
use App\Middlewares\AuthMiddleware;
use Yohpal\Application\YPRouter;

$router = new YPRouter();  

// Define routes 
// web routes
// Landing page routes
$router->req('GET', '/', [YohPalController::class, 'index']);
$router->req('GET', '/index', [YohPalController::class, 'index']); 