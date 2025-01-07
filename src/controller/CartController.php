<?php
class CartController
{
    public function getFormForCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];


        require_once "./../model/UserProduct.php";
        require_once "./../model/Product.php";

        $userProducts = new UserProduct();
        $product = new Product();
        $userProducts = $userProducts->selectAllByUserId($userId);
        if (empty($userProducts)) {
            require_once './../view/cart.php';
        } else {
            foreach ($userProducts as $userProduct) {
                $productIds [] = $userProduct['product_id'];

            }

            $products = $product->getAllByIds($productIds);


            foreach ($userProducts as $userProduct) {
                foreach ($products as &$product) {
                    if ($product['id'] === $userProduct['product_id']) {
                        $product['amount'] = $userProduct['amount'];
                    }
                }
                unset($product);
            }

            $total = 0;
            require_once './../view/cart.php';
        }
    }

    public function getFormAddProductInCart()
    {
    require_once './../view/add_product.php';
    }

    public function addProductInCart()
    {
        $errors = $this->validateAddProduct($_SESSION['user_id'], $_POST);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];
            require_once './../model/UserProduct.php';
            $user_products = new UserProduct();
            $all = $user_products->selectOneByUseridAndProductId($productId, $userId);

            if (!empty($all['product_id']) != $productId) {
                $user_products->addToCart($userId, $productId, $amount);
            }

            else {
                $user_products->updateToCart($userId, $productId, $amount);
            }

            require_once './../model/Product.php';
            $product = new Product();
            $products = $product->getProductsForFormOfCatalog();
            require_once "./../view/catalog.php";

        } else {
            require_once './../view/add_product.php';
        }
    }
    private function validateAddProduct(int $userId, array $arr) : array
    {
        $productId = $arr['product_id'];
        $errors = [];
        require_once './../model/UserProduct.php';
        require_once './../model/Product.php';
        if (!isset($userId)) {
            header('Location: /login');
        }

        if (!isset($productId)) {
            $errors ['product_id'] = 'поле product_id должно быть заполнено';
        } elseif (!is_numeric($arr['product_id'])){
            $errors ['product_id'] = 'product_id не может содержать буквы';
        }
        else {
            $products = new Product();
            $watch= $products->getById($productId);
            if ($watch == false) {
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