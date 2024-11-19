<?php
function validate(array $arr): array
{
    $errors = [];
    if (isset($arr["name"])) {
        $name = $arr["name"];
        if (empty($name)) {
            $errors["name"] = 'имя не может быть пустым';
        } elseif (strlen($name)<2 || strlen($name)>20) {
            $errors["name"] = 'имя не может иметь меньше 2 символов или больше 20';
        } elseif (is_numeric($name)) {
            $errors["name"] = 'имя не может быть числом';
        } elseif (strpos($name, " ") !== false){
            $errors["name"] = 'в имени не может быть пробел';
        }
    } else {
        $errors ["name"] = "поле 'Name' должно быть заполнено";
    }

    if (isset($arr["email"])) {
        if (empty($email)) {
            $errors["email"] = 'email не может быть пустым';
        } elseif (strpos($email, "@") === false){
            $errors["email"] = 'в email должен быть знак @';
        } elseif (strlen($email)<2 || strlen($email)>20) {
            $errors["email"] = 'email не может иметь меньше 2 символов или больше 20';
        }
    }else {
        $errors ["email"] = "поле 'email' должно быть заполнено";
    }
    if (isset($arr['password'])) {
        $password = $arr["password"];
        if (empty($password)) {
            $errors['password'] = 'пароль не может быть пустым';
        } elseif (strlen($password)<2 || strlen($password)>20) {
            $errors['password'] = 'пароль не может иметь меньше 2 символов или больше 20';
        } elseif (is_numeric($password)) {
            $errors['password'] = 'пароль не может быть числом';
        } elseif (strpos($password, " ") !== false) {
            $errors['password'] = 'пароль не может содержать пробел';
        }
    } else {
        $errors ['password'] = "поле 'password' должно быть заполнено";
    }

    if (isset($arr['password-repeat'])) {
        $PasswordRepeat = $arr["password-repeat"];
        if (empty($PasRep)) {
            $errors['password-repeat'] = 'пароль не может быть пустым';
        } elseif ($PasRep !== $password) {
            $errors['password-repeat'] = 'пароли должны совпадать';
        }
    } else {
        $errors ['password-repeat'] = "поле 'Repeat Password' должно быть заполнено";
    }

    $email = $arr["email"];
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $userdata = $stmt->fetch();
    if ($userdata !== false) {
        $errors["email"] = 'такой email уже зарегистрирован';
    }

    return $errors;

}

$errors = validate($_POST);

if (empty($errors)) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
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
