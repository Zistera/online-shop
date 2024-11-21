<?php
$requestURI = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestURI === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }

} elseif ($requestURI === '/register') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }

} elseif ($requestURI === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog.php';
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }

}   elseif ($requestURI === '/add-product') {
    if ($requestMethod === 'GET') {
    require_once './get_add_product.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_add_product.php';
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }
}
else {
        http_response_code(404);
        require_once './404.php';
    }
