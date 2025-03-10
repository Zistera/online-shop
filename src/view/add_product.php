<?php
if (!isset($_SESSION['user_id'])) {
header('Location: /login');
}
?>
<form action="add-product" method="POST">
    <div class="container">
        <button type="button" class="btn btn-primary my-2 my-sm-0" data-toggle="modal"
                data-target="#staticBackdrop">
            <i class="fas fa-shopping-cart marginright total-count"></i>
            <a class="navbar-brand" href="logout"><strong>Logout </strong></a>
        </button>
        <h1>Добавление продукта в корзину</h1>
        <hr>
        <label for="name"><b>ID товара</b></label>
        <label style="color: red">
            <?php if (!empty($errors["product_id"])){
                print_r($errors["product_id"]);} ?> </label>
        <input type="text" placeholder="ID товара" name="product_id" id="product_id" required>

        <label for="email"><b>Количество</b></label>
        <label style="color: red">
            <?php if (!empty($errors["amount"])){
                print_r($errors["amount"]);} ?> </label>
        <input type="text" placeholder="Количество" name="amount" id="amount" required>

        <button type="submit" class="registerbtn">Добавить</button>
    </div>
    <div class="container signin">
        <p><a href="catalog">Вернуться в каталог</a>.</p>
    </div>

</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
        background-image: url("https://gendalf.ru/upload/iblock/35f/uxg3gjajy17fz81u4f7ds0t1rh3x9zvs/shablon-desktop-bitriks-kopiya-_1_.webp");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        background-attachment: fixed;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
