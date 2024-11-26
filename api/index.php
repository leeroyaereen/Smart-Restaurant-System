<?php

    require_once "../config/constants.php";
    require_once "./routes.php";
    
    // Parse the request URI
    $request = trim($_SERVER['REQUEST_URI'], '/');

    // Remove the "api/" base path if hosted in a subdirectory
    $basePath = BASE_PATH . '/api';
    if (strpos('/' . $request, $basePath) === 0) {
        $request = substr($request, strlen($basePath));
    }
    // Route the request
    route($request);
?>