<?php
    session_start();
    require_once "../config/constants.php";
    require_once "./routes.php";
    
    // if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    //     // This is NOT an AJAX request
    //     header('Content-Type: text/html');
    //     echo "<h1>Welcome to the API</h1><p>This endpoint is meant for programmatic access only.</p>";
    //     exit;
    // }
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