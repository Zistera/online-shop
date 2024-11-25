<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}
function validate($user_id, $arr)
{
    $product_id = $arr['product_id'];
    $errors = [];
    if (!isset($user_id)) {
        header('Location: /login');
    }

    if (!isset($product_id)) {
        $errors ['product_id'] = 'поле product_id должно быть заполнено';
    } elseif (!is_numeric($arr['product_id'])){
        $errors ['product_id'] = 'product_id не может содержать буквы';
    }
    else {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->query("SELECT * FROM products WHERE id = $product_id");
        $all= $stmt->fetchall();
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
$errors = validate($_SESSION['user_id'], $_POST);

if (empty($errors)) {
    $userdata = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];

    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->query("SELECT product_id, amount FROM  user_products WHERE product_id = $product_id AND user_id = $userdata");
    $all = $stmt->fetch();

    if (!empty($all['product_id']) != $product_id) {
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userdata, 'product_id' => $product_id, 'amount' => $amount]);
    }

    else {
        $stmt = $pdo->query("UPDATE user_products SET amount=amount+$amount WHERE product_id= $product_id AND user_id= $userdata");
        //$stmt->execute(['amount' => $amount]);
    }


    $out = "Товар с id №{$product_id} был добавлен в вашу корзину в количестве {$amount}";
    require_once 'catalog.php';

} else {
    require_once 'get_add_product.php';
}

