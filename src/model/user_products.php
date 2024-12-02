<?php
class user_products
{
    public function selectOneByUseridAndProductId(int $product_id, int $userdata) : array|false
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT product_id, amount FROM  user_products WHERE product_id = :product_id AND user_id = :userdata");
        $stmt->execute(['product_id' => $product_id, 'userdata'=> $userdata]);
        return $stmt->fetch();
    }

    public function selectAllById(int $userdata) : array|false
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->query("SELECT * FROM user_products WHERE user_id = $userdata ");
        return $stmt->fetchall();
    }
    public function addToCart(int $userdata, int $product_id, int $amount) : void
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userdata, 'product_id' => $product_id, 'amount' => $amount]);
    }
    public function updateToCart(int $userdata, int $product_id, int $amount) : void
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount=amount+:amount WHERE product_id= :product_id AND user_id= :userdata");
        $stmt->execute(['amount' => $amount, 'product_id' => $product_id, 'userdata' => $userdata]);
    }
}