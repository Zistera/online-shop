<?php
require_once "./../model/Model.php";
class Order extends Model
{
    public function createOrder(string $name, string $email, string $address, int $number, int $userId, int $total): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders(name, email, address, number, user_id, total) VALUES (:name, :email, :address, :number, :user_id, :total)");
        $stmt->execute(['name' => $name, 'email' => $email, 'address' => $address, 'number' => $number, 'user_id' => $userId, 'total' => $total]);
    }

    public function getOrderIdByUserId(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT MAX(id) FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

}