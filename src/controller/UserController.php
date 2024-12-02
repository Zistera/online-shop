<?php
class UserController
{
    public function getRegistrationForm()
    {
        require_once './../view/registrateform.php';
    }
    public function registrate()
    {
        $errors = $this->validateReg($_POST);

        if (empty($errors)) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $hash = password_hash($password, PASSWORD_DEFAULT);
            require_once './../model/users.php';
            $users = new user ();
            $users->create($name, $email, $hash);
            header('Location: /login');

        } else {
            require_once './../view/registrateform.php';
        }
    }
    private function validateReg(array $arr): array
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
            $email = $arr["email"];
            if (empty($email)) {
                $errors["email"] = 'email не может быть пустым';
            } elseif (strpos($email, "@") === false){
                $errors["email"] = 'в email должен быть знак @';
            } elseif (strlen($email)<2 || strlen($email)>20) {
                $errors["email"] = 'email не может иметь меньше 2 символов или больше 20';
            }else {
                require_once './../model/users.php';
                $users = new user ();
                $userdata = $users->select($email);
                if ($userdata !== false) {
                    $errors["email"] = 'такой email уже зарегистрирован';
                }
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
            $password = $arr["password"];
            $PasRep = $arr["password-repeat"];
            if (empty($PasRep)) {
                $errors['password-repeat'] = 'пароль не может быть пустым';
            } elseif ($PasRep !== $password) {
                $errors['password-repeat'] = 'пароли должны совпадать';
            }
        } else {
            $errors ['password-repeat'] = "поле 'Repeat Password' должно быть заполнено";
        }

        return $errors;

    }

    public function getLoginForm()
    {
        require_once './../view/login.php';
    }
    public function login()
    {
        $errors = $this->validateLog($_POST);

        if (empty($errors)) {
            $email = $_POST["email"];
            $pass = $_POST["password"];
            require_once './../model/users.php';
            $users = new user ();
            $userdata = $users->select($email);

            if ($userdata == false) {
                $errors['email'] = "Логин или пароль не совпадает";
                require_once './../view/login.php';
            } else {

                if (password_verify($pass, $userdata["password"])) {
                    $_SESSION['user_id'] = $userdata['id'];
                    header('Location: /catalog');
                } else {
                    $errors["email"] = 'Логин или пароль не совпадает';
                    require_once './../view/login.php';
                }
            }

        } else {
            require_once './../view/login.php';
        }
    }
    private function validateLog(array $arr): array
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

    public function logout()
    {
        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: /login');
    }
}