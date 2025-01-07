<?php
require_once "./../model/Model.php";
class Product extends Model
{
    public function getById($productId) : array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute([$productId]);
        return $stmt->fetch();
    }

    public function getAllByIds($productId) : array|false
    {
        $place_holders = '?' . str_repeat(', ?', count($productId) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($place_holders)");
        $stmt->execute($productId);
        return $stmt->fetchAll();
    }

    public function getProductsForFormOfCatalog() : array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchall();
    }
}
