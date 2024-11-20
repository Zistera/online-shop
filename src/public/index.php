<?php
$requestURI = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestURI === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    }
} elseif ($requestURI === '/register') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    }
} elseif ($requestURI === '/catalog') {
    require_once './catalog.php';
} else {
    http_response_code(404);
    require_once './404.php';
}