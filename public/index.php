<?php
include '../config/constants.php';

$request_uri = $_SERVER['REQUEST_URI']; // Get the requested URI

// Remove query string (e.g., ?key=value)
$request_path = parse_url($request_uri, PHP_URL_PATH);
$request_view = substr($request_path, strlen(BASE_PATH));

// Define routes and map them to specific view files
$routes = [
    '/' => 'views/MainDashboard.php',
    '/menu' => 'views/ContentMenu.php',
    '/confirm-order' => 'views/MyTrayItems.php',
    // '/about' => 'views/about.php',
    // '/contact' => 'views/contact.php',
    '/error' => 'views/404.php'
];

// Check if the requested path matches a defined route
if (array_key_exists($request_view, $routes)) {
    include $routes[$request_view];
} else {
    include $routes['/error'];
}

?>
