<?php
require_once "./../controller/CartController.php";
require_once "./../controller/OrderController.php";
require_once "./../controller/ProductController.php";
require_once "./../controller/UserController.php";
class App
{
    private array $routes =
        [
            '/login' => [
                'GET' => [
                    'class' => 'userController',
                    'method' => 'getLoginForm'
                ],
                'POST' => [
                    'class' => 'userController',
                    'method' => 'postLoginForm'
                ]
            ],

            '/register' => [
                'GET' => [
                    'class' => 'userController',
                    'method' => 'getRegistrationForm'
                ],
                'POST' => [
                    'class' => 'userController',
                    'method' => 'postRegistrationForm'
                ]
            ],

            '/catalog' => [
                'GET' => [
                    'class' => 'productController',
                    'method' => 'getGormOfCatalog'
                ]
            ],

            '/add-product' => [
                'GET' => [
                    'class' => 'cartController',
                    'method' => 'getFormAddProductInCart'
                ],
                'POST' => [
                    'class' => 'cartController',
                    'method' => 'addProductInCart'
                ]
            ],

            '/cart' => [
                'GET' => [
                    'class' => 'cartController',
                    'method' => 'getFormForCart'
                ]
            ],

            '/logout' => [
                'GET' => [
                    'class' => 'userController',
                    'method' => 'logout'
                ]
            ],

            '/order' => [
                'GET' => [
                    'class' => 'orderController',
                    'method' => 'getProductsForFormOrder'
                ],
                'POST' => [
                    'class' => 'orderController',
                    'method' => 'postOrderForm'
                ]
            ],
        ];


    public function run() : void
    {
        session_start();

        $URI = $_SERVER['REQUEST_URI'];
        $METHOD = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($URI, $this->routes)) {
            $methods = $this->routes[$URI];
            if (array_key_exists($METHOD, $methods)) {
                $handler = $methods[$METHOD];
                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();
                $obj->$method();
            } else {
                echo "{$METHOD} не поддерживается адрессом {$URI}";
            }
        } else {
            http_response_code(404);
            require_once './../view/404.php';
        }
    }
}
