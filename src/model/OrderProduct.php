<?php
require_once "./../model/Model.php";
class OrderProduct extends Model
{
    public function createOrderProduct(int $productId, int $productAmount, int $productPrice, int $orderId) : void
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders_products (product_id, amount, price, order_id) VALUES (:product_id, :amount, :price, :order_id)");
        $stmt->execute(['product_id' => $productId, 'amount' => $productAmount, 'price' => $productPrice, 'order_id' => $orderId]);
    }
}