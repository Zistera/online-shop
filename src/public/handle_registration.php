<?php
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST['password'];
$PasRep = $_POST['password-repeat'];
$err = [];
if (isset($name)) {
    $name = $_POST["name"];
    if (empty($name)) {
    $err["name"] = 'имя не может быть пустым';
    } elseif (strlen($name)<2 || strlen($name)>20) {
    $err["name"] = 'имя не может иметь меньше 2 символов или больше 20';
    } elseif (is_numeric($name)) {
    $err["name"] = 'имя не может быть числом';
    } elseif (strpos($name, " ") !== false){
    $err["name"] = 'в имени не может быть пробел';
}
} else {
   $err ["name"] = "поле 'Name' должно быть заполнено";
}
if (isset($email)) {
    if (empty($email)) {
        $err["email"] = 'email не может быть пустым';
    } elseif (strpos($email, "@") === false){
        $err["email"] = 'в email должен быть знак @';
    } elseif (strlen($email)<2 || strlen($email)>20) {
    $err["email"] = 'email не может иметь меньше 2 символов или больше 20';
} }else {
    $err ["email"] = "поле 'email' должно быть заполнено";
}
if (isset($password)) {
    if (empty($password)) {
        $err['password'] = 'пароль не может быть пустым';
    } elseif (strlen($password)<2 || strlen($password)>20) {
        $err['password'] = 'пароль не может иметь меньше 2 символов или больше 20';
    } elseif (is_numeric($password)) {
        $err['password'] = 'пароль не может быть числом';
    } elseif (strpos($password, " ") !== false) {
        $err['password'] = 'пароль не может содержать пробел';
    }
} else {
    $err ['password'] = "поле 'password' должно быть заполнено";
}
if (isset($PasRep)) {
    if (empty($PasRep)) {
        $err['password-repeat'] = 'пароль не может быть пустым';
    } elseif ($PasRep !== $password) {
        $err['password-repeat'] = 'пароли должны совпадать';
    }
} else {
    $err ['password-repeat'] = "поле 'Repeat Password' должно быть заполнено";
}

if (empty($err)) {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    print_r($stmt->fetch());
} else {
    require_once './get_registration.php';
}
?>
