<?php
require_once './../controller/UserController.php';
$userController = new UserController();

require_once './../controller/ProductController.php';
$productController = new ProductController();

require_once './../controller/CartController.php';
$cartController = new CartController();

session_start();

$requestURI = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestURI === '/login') {
    if ($requestMethod === 'GET') {
        $userController->getLoginForm();
    } elseif ($requestMethod === 'POST') {
        $userController->login();
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }

} elseif ($requestURI === '/register') {
    if ($requestMethod === 'GET') {
        $userController->getRegistrationForm();
    } elseif ($requestMethod === 'POST') {
        $userController->registrate();
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }

} elseif ($requestURI === '/catalog') {
    if ($requestMethod === 'GET') {
        $productController->getCatalog();
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }

}   elseif ($requestURI === '/add-product') {
    if ($requestMethod === 'GET') {
    $cartController->getAddToCartForm();
    } elseif ($requestMethod === 'POST') {
        $cartController->addToCart();
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }



} elseif ($requestURI === '/cart') {
    if ($requestMethod === 'GET') {
        $cartController->getCartForm();
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }




} elseif ($requestURI === '/logout') {
    if ($requestMethod === 'GET') {
        $userController->logout();
    } else {
        print_r("$requestMethod не поддерживается адресом $requestURI\n");
    }
}else {
        http_response_code(404);
        require_once './../view/404.php';
    }


