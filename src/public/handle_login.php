<?php
function validations(array $arr)
{
    $errors = [];
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        if (empty($email)) {
            $errors["email"] = 'email не может быть пустым';
        } elseif (strlen($email) < 2) {
            $errors["email"] = 'email не может меньше 2 символов';
        }
    } else {
        $errors ["email"] = "поле 'email' должно быть заполнено";
    }
    if (isset($_POST["password"])) {
        $pass = $_POST["password"];
        if (empty($pass)) {
            $errors["password"] = 'имя не может быть пустым';
        } elseif (strlen($pass) < 2) {
            $errors["password"] = 'email не может меньше 2 символов';
        }
    } else {
        $errors ["password"] = "поле 'Username' должно быть заполнено";
    }
    return $errors;
}
$errors = validations($_POST);
if (empty($errors)) {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $userdata = $stmt->fetch();
    if ($userdata === false) {
        $errors['email'] = "Такого логина не существует";
        require_once './get_login.php';
    } else {
        if (password_verify($pass, $userdata["password"])) {
            echo "Вы успешно верифицировались!";
        } else {
            $errors["password"] = 'ваш пароль не совпадает';
            require_once './get_login.php';
        }
    }
} else {
    require_once './get_login.php';
}