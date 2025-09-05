<?php

namespace Yohpal\Application;

use \AltoRouter;
use \ReflectionClass;
use \ReflectionMethod;
use Yohpal\Application\Auth;
use Yohpal\Application\YPRequest;
use App\Middelwares\AuthMiddleware;

/**
 * Custom Router extending AltoRouter to allow automatic controller
 * and method dependency injection using Reflection.
 * 
 * Right here with YohPal forever!
 */
class YPRouter extends AltoRouter
{
    public function __construct()
    {
        parent::__construct();
        $domain = app_url();
        $parsedUrl = parse_url($domain);
        $basePath = isset($parsedUrl['path']) ? $parsedUrl['path'] : '/';

        $this->basePath = rtrim($basePath, '/');

        if ($this->basePath == '/') {
            $this->basePath = '';
        }

        $this->setBasePath($this->basePath);
    }

    /**
     * Register a route
     *
     * @param string $httpMethod
     * @param string $route
     * @param array $target [ClassName::class, 'methodName']
     * @param array $middlewares [auth, session, etc...]
     * @return void
     * @throws \Exception
     */
    public function req($httpMethod, $route, $target, $middlewares = [])
    {
        if (!is_array($target) || count($target) !== 2) {
            throw new \Exception("Invalid target format. Expected [ClassName::class, 'methodName'].");
        }

        [$class, $methodName] = $target;

        if (!class_exists($class) || !method_exists($class, $methodName)) {
            throw new \Exception("Handler class or method not found: {$class}::{$methodName}");
        } 

        $this->map($httpMethod, $route, function ($path = null) use ($class, $methodName, $middlewares) {
            // Initialize all middlewares and fire them here:
            foreach ($middlewares as $middlewareClass) {
                if (!class_exists($middlewareClass)) {
                    throw new \Exception("Middleware class '{$middlewareClass}' not found.");
                }
        
                $middleware = new $middlewareClass();
        
                if (!method_exists($middleware, 'handle')) {
                    throw new \Exception("Middleware '{$middlewareClass}' must have a handle() method.");
                }
        
                // If handle() returns false or throws, it rescinds request
                $result = $middleware->handle();

                if (!$result) { 
                    throw new \Exception("Request blocked by middleware: {$middlewareClass}");
                }
            }

            // Continue with route handling.
            $reflection = new ReflectionClass($class);
            $constructorArgs = [];

            // Resolve constructor dependencies
            if ($constructor = $reflection->getConstructor()) {
                foreach ($constructor->getParameters() as $param) {
                    $type = $param->getType();
                    if ($type && !$type->isBuiltin()) {
                        $constructorArgs[] = new ($type->getName());
                    }
                }
            }

            $controller = $reflection->newInstanceArgs($constructorArgs);

            $routeParams = func_get_args();

            // Resolve method dependencies
            $method = new ReflectionMethod($controller, $methodName);
            $methodArgs = [];

            foreach ($method->getParameters() as $i => $param) {
                $type = $param->getType();

                if ($type && !$type->isBuiltin()) {
                    if ($type->getName() === YPRequest::class) {
                        $methodArgs[] = new YPRequest();
                    } else {
                        $methodArgs[] = new ($type->getName());
                    }
                } else {
                    $paramName = $param->getName() ?: null;
                    $methodArgs[] = $routeParams ?? $paramName;
                }
            }

            return $method->invokeArgs($controller, $methodArgs);
        });
    }

    /**
     * Match the route and run it.
     *
     * @return void
     */
    public function dispatch()
    {
        $match = $this->match();

        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            echo view('404');
        }
    }
}
