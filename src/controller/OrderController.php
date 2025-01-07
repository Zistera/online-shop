<?php
require_once "./../model/UserProduct.php";
require_once "./../model/Product.php";
require_once "./../model/Order.php";
require_once "./../model/OrderProduct.php";
class OrderController
{
    public function getProductsForFormOrder()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
        }

        $userProduct = new UserProduct();
        $products = new Product();
        $userProducts = $userProduct->selectAllByUserId($userId);

        $productIds = [];

        foreach ($userProducts as $userProduct1) {
            $productIds [] = $userProduct1['product_id'];
        }
        if (!empty($productIds)) {
            $products = $products->getAllByIds($productIds);
        } else {
            header("Location: /catalog");
        }

        foreach ($userProducts as $userProduct2) {
            foreach ($products as &$product) {
                if ($product['id'] === $userProduct2['product_id']) {
                    $product['amount'] = $userProduct2['amount'];
                }
            }
            unset($product);
        }
        $total = 0;
        require_once "./../view/formofadress.php";
    }

    public function postOrderForm()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $errors = $this->valadateByOrderForm($_POST);
        if (!empty($errors)) {
            $this->getProductsForFormOrder();
            exit;
        }
        $userId = $_SESSION['user_id'];
        $name = $_POST['Name'];
        $email = $_POST['Email'];
        $address = $_POST['Address'];
        $number = $_POST['Number'];

        $userProducts = new UserProduct();
        $products = new Product();
        $userProducts2 = $userProducts->selectAllByUserId($userId);

        $productIds = [];
        foreach ($userProducts2 as $userProduct) {
            $productIds [] = $userProduct['product_id'];

        }

        $products1 = $products->getAllByIds($productIds);

        $total = 0;
        foreach ($userProducts2 as $userProduct) {
            foreach ($products1 as $product) {
                if ($product['id'] === $userProduct['product_id']) {
                    $product['amount'] = $userProduct['amount'];
                    $total += $product['amount'] * $product['price'];

                }
            }
        }
        $order = new Order();
        $order->createOrder($name, $email, $address, $number, $userId, $total);
        $orderId = $order->getOrderIdByUserId($userId);
        $orderId = $orderId['max'];

        $ordersProducts = new OrderProduct();
        foreach ($userProducts2 as $userProduct) {
            foreach ($products1 as $product) {
                if ($product['id'] === $userProduct['product_id']) {
                    $product['amount'] = $userProduct['amount'];
                    $ordersProducts->createOrderProduct($product['id'], $product['amount'], $product['price'], $orderId);

                }
            }
        }
        $userProducts->deleteProductsThisUserInCart($userId);

        $products = $products->getProductsForFormOfCatalog();
        require_once "./../view/catalog.php";

    }

    private function valadateByOrderForm(array $arr) : array
    {
        $errors = [];
        if (isset($arr["Name"])) {
            $name = $arr["Name"];
            if (empty($name)) {
                $errors["name"] = 'имя не может быть пустым';
            } elseif (strlen($name) < 2 || strlen($name) > 20) {
                $errors["name"] = 'имя не может иметь меньше 2 символов или больше 20';
            } elseif (is_numeric($name)) {
                $errors["name"] = 'имя не может быть числом';
            } elseif (strpos($name, " ") !== false) {
                $errors["name"] = 'в имени не может быть пробел';
            }
        } else {
            $errors ["name"] = "поле 'Name' должно быть заполнено";
        }

        if (isset($arr["Email"])) {
            $email = $arr["Email"];
            if (empty($email)) {
                $errors["email"] = 'email не может быть пустым';
            } elseif (strpos($email, "@") === false) {
                $errors["email"] = 'в email должен быть знак @';
            } elseif (strlen($email) < 2 || strlen($email) > 20) {
                $errors["email"] = 'email не может иметь меньше 2 символов или больше 20';
            }

        } else {
            $errors ["email"] = "поле 'email' должно быть заполнено";
        }
        if (isset($arr['Number'])) {
            $number = $arr["Number"];
            if (empty($number)) {
                $errors['number'] = 'пароль не может быть пустым';
            } elseif (strlen($number) < 2 || strlen($number) > 20) {
                $errors['number'] = 'пароль не может иметь меньше 2 символов или больше 20';
            } elseif (strpos($number, " ") !== false) {
                $errors['number'] = 'number не может содержать пробел';
            }
        } else {
            $errors ['number'] = "поле 'number' должно быть заполнено";
        }


        return $errors;

    }
}