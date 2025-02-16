<?php
include '../config/constants.php';

$request_uri = $_SERVER['REQUEST_URI']; // Get the requested URI

// Remove query string (e.g., ?key=value)
$request_path = parse_url($request_uri, PHP_URL_PATH);
$request_view = substr($request_path, strlen(BASE_PATH));

// Define routes and map them to specific view files
session_start();
if ($request_view == '/'){
    if (isset($_SESSION['phoneNumber'])){
        header("Location:".BASE_PATH."/menu");
    }
    else{
        header("Location:".BASE_PATH."/login");
    }
}

$routes = [
    '/' => 'views/Dashboard.html',
    '/dashboard' => 'views/Dashboard.html',
    '/menu' => 'views/ContentMenu.php',
    '/confirm-order' => 'views/MyTrayItems.php',
    '/order-status' => 'views/OrderStatus.php',
    '/register' => 'views/RegisterPage.php',
    '/login' => 'views/LoginPage.php',
    '/order-monitor' => 'views/OrderMonitor.php',
    '/orders' => 'views/OrderStatus.php',
    '/contact' => 'views/contact.php',
    '/error' => 'views/404.php'
];

// Check if the requested path matches a defined route
if (array_key_exists($request_view, $routes)) {
    include $routes[$request_view];
} else {
    include $routes['/error'];
}
?>
