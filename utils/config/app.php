<?php 

return [
    /**
     * ------------------------------------------------------------------------
     *                             APPLICATION CONFIGURATION
     * ------------------------------------------------------------------------
     * This file contains essential configurations for the application.
     * Please review and modify settings if need be, for your application.
     * ------------------------------------------------------------------------
     */

    /**
     * APP NAME
     *
     * This is the name of the application if no APP_NAME is set in the .env file.
     * You're permitted to change this name to a name of your preference.
     */
    'APP_NAME' => 'YohPal Hustle',

    /**
     * APP DOMAIN.
     *
     * The application runs on this URL by default.
     * You can change it here or set it in the .env file.
     *
     * Use http://127.0.0.1 or http://localhost
     */
    'APP_DOMAIN' => "http://127.0.0.1:8200",

    /**
     * APP DEBUG.
     *
     * The application raises exceptions upon this config being setup to true.
     * Set this to true to show debug errors gracefully.
     */
    'APP_DEBUG' => false,

    /**
     * API's DEBUG.
     *
     * The application raises exceptions upon this config being setup to true.
     * Set this to true to show API debug errors gracefully.
     */
    'API_DEBUG' => false,

    /**
     * Autoroute by default
     *
     * Use the loaded url upon browser navigations.
     */
    'AUTO_ROUTE' => false,

    /**
     * APP SECRET
     *
     * This is a secret key that gets used by the application to encode or decode a payload where
     * applicable.
     */
    'APP_SECRET' => 'af63ff81e7d3b9d85ff76b2f59b3b7f350186bd7c0c4e513d852a0634a81c722',

    /**
     * TOKEN EXPIRY
     *
     * This is time duration the application authentication token is suppossed to take before it expires.
     * The duration is supposed to be denoted in hours format for the middleware to take into account the
     * expiry detection procedure needed.
     */
    'TOKEN_EXPIRY' => 1,

    /**
     * Root DIR Path
     *
     * This is the root directory of the application.
     */
    'ROOT_DIRECTORY' => $_SERVER['DOCUMENT_ROOT'],

    /**
     * Resource Views Directory
     *
     * This is the directory where the views are stored. This is the default directory.
     * The folder is primarily used to store the views of the application.
     */
    'RESOURCE_VIEWS_DIRECTORY' => ['pages', 'partials'],

    /**
     * Controller Path
     *
     * This is the directory where the controllers are stored.
     * You can add more directories to the array.
     */
    'CONTROLLER_PATH' => [
        getcwd() . "/features/auth",
        getcwd() . "/features/controllers",
    ],

    /**
     * Model Path
     *
     * This is the directory where the models are stored.
     */
    'MODEL_PATH' => getcwd() . "/data/models",

    /**
     * Middleware Path
     *
     * This is the directory where the middleware are stored.
     */
    'MIDDLEWARE_PATH' => getcwd() . "/features/middlewares",

    /**
     * Route Path
     *
     * This is the directory where the routes are stored.
     * You can change it here or set it in the .env file.
     */
    'ROUTE_PATH' => getcwd() . '/features/routes',

    /**
     * Public Path
     *
     * This is the directory where the public files are stored.
     */
    'PUBLIC_PATH' => "assets",

    /**
     * Bindings Directory Path
     *
     * This is the directory where the bindings configuration files are stored. The bindings are
     * separated from the system configuration files rather, to keep the app business logical.
     */
    'BINDINGS_PATH' => "bindings",

    /**
     * Set default timezone to Africa/Nairobi
     */
    'TIMEZONE' => 'Africa/Nairobi',
];
