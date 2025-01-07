<?php
require_once "./../model/Model.php";
class User extends Model
{
    public function createUserdata(string $name, string $email, string $password) : void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function selectByEmail($email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
