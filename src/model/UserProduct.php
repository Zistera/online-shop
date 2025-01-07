<?php
require_once "./../model/Model.php";
class UserProduct extends Model
{
    public function selectOneByUseridAndProductId(int $productId, int $userId) : array|false
    {
        $stmt = $this->pdo->prepare("SELECT product_id, amount FROM  user_products WHERE product_id = :product_id AND user_id = :userId");
        $stmt->execute(['product_id' => $productId, 'userId'=> $userId]);
        return $stmt->fetch();
    }

    public function selectAllByUserId(int $userId) : array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchall();
    }

    public function addToCart(int $userId, int $productId, int $amount) : void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function updateToCart(int $userId, int $productId, int $amount) : void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount=amount+:amount WHERE product_id= :product_id AND user_id= :userId");
        $stmt->execute(['amount' => $amount, 'product_id' => $productId, 'userId' => $userId]);
    }

    public function deleteProductsThisUserInCart(int $userId) : void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
}