<?php
$email = $_POST["email"];
$pass = $_POST["password"];
$err = [];
if (isset($email)) {
    $email = $_POST["email"];
    if (empty($email)) {
        $err["email"] = 'email не может быть пустым';
    } elseif (strlen($email) < 2) {
        $err["email"] = 'email не может меньше 2 символов';
    }
} else {
    $err ["email"] = "поле 'email' должно быть заполнено";
}
if (isset($pass)) {
    $pass = $_POST["password"];
    if (empty($pass)) {
        $err["password"] = 'имя не может быть пустым';
    } elseif (strlen($pass) < 2) {
    $err["password"] = 'email не может меньше 2 символов';
}} else {
    $err ["password"] = "поле 'Username' должно быть заполнено";
}
if (empty($err)) {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $hash = $stmt->fetch();
    if ($hash === false) {
        $err['email'] = "Такого логина не существует";
        require_once './get_login.php';
    } else {
        if (password_verify($pass, $hash["password"])) {
            echo "Вы успешно верифицировались!";
        } else {
            $err["password"] = 'ваш пароль не совпадает';
            require_once './get_login.php';
        }
    }
} else {
    require_once './get_login.php';
}