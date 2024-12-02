<?php
class products
{
    public function getById($product_id) : array|false
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute([$product_id]);
        return $stmt->fetch();
    }

    public function getAllProductInCart($place_holders, $product_id) : array|false
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($place_holders)");
        $stmt->execute($product_id);
        return $stmt->fetchAll();
    }
}
