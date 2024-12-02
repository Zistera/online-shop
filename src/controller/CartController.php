<?php
class CartController
{
    public function getCartForm()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }else {
            $userdata = $_SESSION['user_id'];
        }

        require_once "./../model/user_products.php";
        require_once "./../model/products.php";

        $cart = new user_products();
        $prod = new products();
        $carts = $cart->selectAllById($userdata);

        $product_id = [];
        $products = [];

        $i = 0;
        foreach ($carts as $value) {
            $product_id [$i]= $value['product_id'];
            $i++;
        }

        $place_holders = '?' . str_repeat(', ?', count($product_id) - 1);
        $products_cart = $prod->getAllProductInCart($place_holders, $product_id);

        $i = 0;
        foreach ($carts as $value) {
            $products [$i] = $products_cart[$i];
            $products [$i]['amount'] = $value['amount'];
            $i++;
        }
        $total = 0;
        require_once './../view/cart.php';
    }

    public function getAddToCartForm()
    {
    require_once './../view/add_product.php';
    }

    public function addToCart()
    {
        $errors = $this->validateAddProduct($_SESSION['user_id'], $_POST);

        if (empty($errors)) {
            $userdata = $_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];
            require_once './../model/user_products.php';
            $user_products = new user_products();
            $all = $user_products->selectOneByUseridAndProductId($product_id, $userdata);

            if (!empty($all['product_id']) != $product_id) {
                $user_products->addToCart($userdata, $product_id, $amount);
            }

            else {
                $user_products->updateToCart($userdata, $product_id, $amount);
            }


            $out = "Товар с id №{$product_id} был добавлен в вашу корзину в количестве {$amount}";
            require_once './../view/catalog.php';

        } else {
            require_once './../view/add_product.php';
        }
    }
    private function validateAddProduct(int $user_id, array $arr) : array
    {
        $product_id = $arr['product_id'];
        $errors = [];
        require_once './../model/user_products.php';
        require_once './../model/products.php';
        if (!isset($user_id)) {
            header('Location: /login');
        }

        if (!isset($product_id)) {
            $errors ['product_id'] = 'поле product_id должно быть заполнено';
        } elseif (!is_numeric($arr['product_id'])){
            $errors ['product_id'] = 'product_id не может содержать буквы';
        }
        else {
            $products = new products();
            $all= $products->getById($product_id);;
            if ($all == false) {
                $errors["product_id"] = 'товара с таким id не существует';
            }
        }

        if (!isset($arr['amount'])) {
            $errors ['amount'] = 'поле amount должно быть заполнено';
        } elseif (!is_numeric($arr['amount'])) {
            $errors ['amount'] = 'количиство не может содержать буквы';
        } elseif ($arr['amount'] < 0){
            $errors ['amount'] = 'количиство не может быть отрицательным';
        }

        return $errors;
    }
}