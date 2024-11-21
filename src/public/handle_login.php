<?php
function validate(array $arr)
{
    $errors = [];
    if (isset($arr["email"])) {
        $email = $arr["email"];
        if (empty($email)) {
            $errors["email"] = 'email не может быть пустым';
        }
    } else {
        $errors ["email"] = "поле 'email' должно быть заполнено";
    }
    if (isset($arr["password"])) {
        $pass = $arr["password"];
        if (empty($pass)) {
            $errors["password"] = 'пароль не может быть пустым';
        }
    } else {
        $errors ["password"] = "поле 'Password' должно быть заполнено";
    }
    return $errors;
}
$errors = validate($_POST);

if (empty($errors)) {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $userdata = $stmt->fetch();

    if ($userdata === false) {
        $errors['email'] = "Логин или пароль не совпадает";
        require_once './get_login.php';
    } else {

        if (password_verify($pass, $userdata["password"])) {
            session_start();
            $_SESSION['user_id'] = $userdata['id'];
            header('Location: /catalog');
        } else {
            $errors["email"] = 'Логин или пароль не совпадает';
            require_once './get_login.php';
        }
    }

} else {
    require_once './get_login.php';
}