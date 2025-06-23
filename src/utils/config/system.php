<?php

return [

    /**
     * Use composer features by setting this config to true.
     * If false, the default SPL_NAMESPACING is used.
     * 
     * Set this to true if composer is configured onto your production environment.
     */
    'COMPOSER_NAMESPACING' => true,

    /**
     * Define Namespacing here, to override the composer autoloading.
     * 
     * This works if COMPOSER_NAMESPACING is set to false. Make sure the vendor modules 
     * are installed before pushing the application to production.
     */
    'SPL_NAMESPACING' => [
        'App\\' => 'features/',
        'Vendor\\Package\\' => 'assets/vendor_modules/',
        'Yohpal\\Application\\' => 'utils/config/app/',
        'Yohpal\\Models\\' => 'data/models/',
        'Yohpal\\Utils\\' => 'utils/Http/',
        'App\\Controllers\\Web\\' => 'features/controllers/Web/',
        'App\\Controllers\\Api\\' => 'features/controllers/Api/',
        'App\\Middlewares\\' => 'features/middlewares'
    ],

];