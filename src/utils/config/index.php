<?php

// Define helper directory
$helperDir = getcwd() . '/utils/helpers/';

// Load all PHP files in the helpers directory
foreach (glob($helperDir . '*.php') as $helperFile) {
    require_once $helperFile;
}

// Globally accessible config container
$GLOBALS['config'] = [
    'app' => include getcwd() . "/utils/config/app.php",
    'system' => include getcwd() . "/utils/config/system.php",
    'custom' => include getcwd() . "/utils/config/custom.php",
];

/**
 * Configuration helper function
 * 
 * @param key|group
 * @return configuration
 */
function config_all($group = 'app')
{
    return $GLOBALS['config'][$group];
}

/**
 * Configuration helper function
 * 
 * @param key|group
 * @return configuration
 */
function config($key, $group = 'app')
{
    return $GLOBALS['config'][$group][$key] ?? null;
}

$GLOBALS['bindings'] = [];
$bindingsPath = config('BINDINGS_PATH');

// Load all PHP files in the bindings directory
$directory = new \RecursiveDirectoryIterator($bindingsPath);
$iterator = new \RecursiveIteratorIterator($directory);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filePath = $file->getPathname();
        $filename = $file->getBasename('.php');
        $key = preg_replace('/Bindings$/', '', $filename);
        $GLOBALS['bindings'][$key] = require $filePath;
    }
}

/**
 * The function acts as config reader for all bindings set 
 */
function binding(string $key = null): mixed
{
    $bindings = $GLOBALS['bindings'];

    if (is_null($key)) {
        return (object) $bindings;
    }

    $parts = explode('.', $key);
    $value = $bindings;

    foreach ($parts as $part) {
        if (is_array($value) && array_key_exists($part, $value)) {
            $value = $value[$part];
        } else {
            return null;
        }
    }

    return $value;
}

/**
 * Returns the Application Url in respective to configuration settings.
 */
function app_url(): string
{
    return config('AUTO_ROUTE') ? '/' : config("APP_DOMAIN");
}

/**
 * Forms & Returns full asset Url in respective to configuration settings
 * & parsed param as filepath.
 */
function asset_url($filepath): string
{
    $domain = rtrim(app_url(), DIRECTORY_SEPARATOR);
    $defined_public_path = preg_replace('/[\/\\\\]/', '', config('PUBLIC_PATH'));

    if (!str_starts_with($filepath, '/') && !str_starts_with($filepath, DIRECTORY_SEPARATOR)) {
        $filepath = DIRECTORY_SEPARATOR . $filepath;
    }

    return $domain . DIRECTORY_SEPARATOR . $defined_public_path . $filepath;
}

/**
 * Set and require autoload to fire up parsing of classes in a more cleaner way.
 * The function sets the autoload in respect to configuration user sets.
 * 
 * @return void
 */
function require_autoload()
{
    // counter usage of both autoloads
    try {
        // require vendor autoload for composer libs management
        if (config('COMPOSER_NAMESPACING', 'system')) {
            require_once getcwd() . "/assets/vendor_modules/autoload.php";
        }

        if (!config('COMPOSER_NAMESPACING', 'system')) {
            require_once getcwd() . "/utils/config/autoload.php";
        }
    } catch (\Throwable $th) {
        echo $th->getMessage();
        exit;
    }
}

/**
 * Extract route from the Request URI
 */
function extract_route(): string
{
    // Skip routing if it's a direct PHP file request
    $requestUri = $_SERVER['REQUEST_URI'];
    $scriptName = $_SERVER['SCRIPT_NAME']; // Application Entry point: "index.php" 

    $basePath = rtrim(dirname($scriptName), '/'); // "/" 
    $cleanUri = parse_url($requestUri, PHP_URL_PATH);

    // Get the route path by trimming the base path from the URI
    $route = '/' . ltrim(str_replace($basePath, '', $cleanUri), '/');

    return $route;
}

/**
 * Fires out the router.
 * 
 * @return Routes Includes the files as they are for route calls.
 */
function setRouter()
{
    $route = extract_route();

    // Skip if it's a direct PHP file
    if (preg_match('/\.php($|\?)/', $route)) {
        return false;
    }

    // Get the route path from the config
    $routePath = config('ROUTE_PATH');

    // if ($routePath && is_dir($routePath)) {
    //     foreach (glob($routePath . '/*.php') as $routeFile) { 
    //         require_once $routeFile;
    //     } 
    // } else {
    //     throw new Exception("ROUTE_PATH is not defined or not a valid directory: {$routePath}");
    // }

    if (!empty($routePath) && is_dir($routePath)) { 
        // Load routes in a stack order
        $routeFiles = []; 
        $allFiles = glob($routePath . '/*.php');

        if ($allFiles === false) {
            throw new RuntimeException("Failed to scan route directory: {$routePath}");
        }
        
        foreach ($allFiles as $file) {
            $filename = basename($file);

            // Ensure app.php comes first if it exists
            if ($filename === 'app.php') {
                array_unshift($routeFiles, $file);
            } else {
                $routeFiles[] = $file;
            }
        }

        // Now require each file in order
        foreach ($routeFiles as $file) {
            require_once $file;
        }

        // Dispatch the YP Router matcher
        if(isset($router) && $router instanceof \Yohpal\Application\YPRouter) {
            $router->dispatch();
        }
    } else {
        throw new RuntimeException(
            "ROUTE_PATH is not defined or not a valid directory: " .
                ($routePath ? $routePath : 'undefined')
        );
    }
}

/**
 * Views the views passed. Accepts the file path of a view,
 * & Optional data array
 * 
 * @param string $viewName The name of the view file (without .php).
 * @param array $data The array to extract and pass to the view.
 * @param bool $raw Whether to return the rendered view content as raw string.
 * @return string|void
 * @throws \Exception If the view is not found.
 */
function view($viewName, $data = [], $raw = false)
{
    $directories = config('RESOURCE_VIEWS_DIRECTORY');

    if (!is_array($directories)) {
        $directories = [$directories];
    }

    // Locate the view file in the given directories
    $viewPath = null;
    foreach ($directories as $dir) {
        $fullPath = getcwd() . DIRECTORY_SEPARATOR . rtrim($dir, '/') . DIRECTORY_SEPARATOR . $viewName . '.php';
        if (file_exists($fullPath)) {
            $viewPath = $fullPath;
            break;
        }
    }

    if (!$viewPath) {
        throw new \Exception("View '{$viewName}' not found in any configured application views directory.", 500);
    }

    // Start output buffering
    ob_start();

    // Extract variables into current scope
    extract($data);

    // Include the view file
    include($viewPath);

    // Get the buffer contents
    $content = ob_get_clean();

    if ($raw) {
        return $content; // Return raw view content
    }

    echo $content;
    exit;
}

/**
 * Route a window to a different page.
 * Accepts a route path param which should be defined already in the routes library.
 */
function route(string $path):void {
    header("Location: $path");
    exit;
}

// require autoloader upon setting the configs
require_autoload();

// Require the PHP Dotenv for configuration settings
use \Dotenv\Dotenv;
use Yohpal\Application\Auth;

$dotenv = Dotenv::createImmutable('.');
$dotenv->safeLoad();

/**
 * Read environment configuration variable and return 
 * the first non-empty value: .env, config(), or default
 */
function env(string $key, $default = null): mixed
{
    $value = $_ENV[$key] ?? config($key) ?? $default;

    if (!is_string($value)) {
        return $value;
    }

    return match (strtolower($value)) {
        'true',  '(true)'  => true,
        'false', '(false)' => false,
        'null',  '(null)'  => null,
        'empty', '(empty)' => '',
        default             => $value,
    };
}

// Fire up the Router when you access 
// inner system parsed routes.
setRouter();

/**
 * Global helper for accessing the authenticated user.
 *
 * @return Auth
 */
function auth()
{
    return new class {
        public function user()
        {
            return Auth::user();
        }

        public function logout()
        {
            return Auth::logout();
        }

        public function login($user)
        {
            return Auth::login($user);
        }
    };
}
