

<body>
<div class="container">
    <div class="wrapper">
        <form action="handle_login.php" METHOD="POST">
            <h1>Login</h1>
            <div class="input-box">
                <label style="color: red">
                    <?php if (!empty($err["email"])){
                        print_r($err["email"]);} ?>
                </label>
                <input type="text" placeholder="Email" name="email" id="email" required>
                <i class='bx bxs-user'></i>
            </div>
            <dive class="input-box">
                <label style="color: red">
                    <?php if (!empty($err["password"])){
                        print_r($err["password"]);} ?>
                </label>
                <input type="password" placeholder="Password" name="password" id="password" required>
                <i class='bx bxs-lock-alt'></i>
            </dive>
            <dive class="remember-forget">

            </dive><br>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <a href="#">Forget password?</a></div>
            <div class="register-link">
                <p>Don't have an account? <a href="get_registration.php">Register</a></p>
            </div>
        </form>
    </div>
</div>
</body>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }
    body {
        font-family: Times New R, sans-serif;
        background-color: #2c2c36;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 90%;
        height: 600px;
        border-radius: 10px;
        background: url(https://i.pinimg.com/564x/b1/8d/bd/b18dbdce168f718f69decc100604b376.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

    .wrapper {
        width: 420px;
        background-color:rgba(16 18 27 / 40%);
        border: 2px solid rgba(255, 255, 255, 02);
        backdrop-filter: blur(20px);
        color: #fff;
        border-radius: 10px;
        padding: 30px 40px;
    }
    .wrapper h1 {
        font-size: 36px;
        text-align: center;
    }
    .wrapper .input-box {
        position: relative;
        width: 100%;
        height: 50px;
        margin: 15px 0;
    }
    .input-box input {
        width: 100%;
        height: 50px;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 40px;
        font-size: 16px;
        color: #fff;
        padding: 20px 45px 20px 20px;
    }
    .input-box input::placeholder {
        color: #fff;
    }
    .input-box i {
        position:absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }
    .wrapper .btn {
        width: 100%;
        height: 45px;
        background-color: #fff;
        border: none;
        outline: none;
        margin-top:20px;
        border-radius: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }
    .wrapper .btn:hover{
        background-color:#ff76ba;
        color:#fff;
    }
    .wrapper .register-link {
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
    }
    .register-link p a {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
    }
    .register-link p a:hover {
        text-decoration: underline;
    }
    .wrapper .register-link a {
        color: #fff;
        font-size: 13px;
    }
</style>