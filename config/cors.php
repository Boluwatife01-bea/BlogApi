<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    
    'paths' => [
        'api/*',                // All API routes
        'sanctum/csrf-cookie',  // Sanctum CSRF endpoint
    ],

    
    'allowed_methods' => ['*'], // GET, POST, PUT, DELETE, etc.

    // Which domains can make requests to your API
    'allowed_origins' => [
        'http://localhost:3000',    // React/Next.js
        'http://127.0.0.1:3000',
        'http://localhost:8080',    // Vue.js
        'http://localhost:5173',    // Vite dev server
        // Add your production domain here later
        // 'https://yourdomain.com',
    ],

    'allowed_origins_patterns' => [],

  
    'allowed_headers' => ['*'],

    // Which headers to expose to the browser
    'exposed_headers' => [],

    // How long the browser can cache preflight requests
    'max_age' => 0,

    // CRITICAL for Sanctum: Allow cookies to be sent cross-origin
    'supports_credentials' => true,
];