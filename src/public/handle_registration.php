<?php
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST['password'];
$PasRep = $_POST['password-repeat'];
$err = [];
if (empty($name)) {
    $err[] = 'имя не может быть пустым';
} elseif (strlen($name)<2 || strlen($name)>20) {
    $err[] = 'имя не может иметь меньше 2 символов или больше 20';
} elseif (is_numeric($name)) {
    $err[] = 'имя не может быть числом';
} elseif (strpos($name, " ") !== false){
    $err[] = 'в имени не может быть пробел';
}
if (empty($email)) {
    $err[] = 'email не может быть пустым';
} elseif (strpos($email, "@") === true){
    $err[] = 'в email должен быть знак @';
}
if (empty($password)) {
    $err[] = 'пароль не может быть пустым';
} elseif (strlen($password)<2 || strlen($password)>20) {
    $err[] = 'пароль не может иметь меньше 2 символов или больше 20';
} elseif (is_numeric($password)) {
    $err[] = 'пароль не может быть числом';
} elseif (strpos($password, " ") !== false) {
    $err[] = 'пароль не может содержать пробел';
}
if (empty($PasRep)) {
    $err[] = 'пароль не может быть пустым';
} elseif ($PasRep !== $password) {
    $err[] = 'пароли должны совпадать';
}
if (!empty($err)) {
    foreach ($err as $e) {
        echo $e . "\n";
    }
    exit;
}
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo -> prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
$stmt = $pdo -> prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);

print_r($stmt->fetch());