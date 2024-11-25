<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}else {
    $userdata = $_SESSION['user_id'];
}
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo->query("SELECT * FROM user_products WHERE user_id = $userdata ");
$cart = $stmt->fetchAll();


$total = 0;
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css'><link rel="stylesheet" href="./style.css">
</head>
<body>

<main>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="catalog"><strong>Вернуться в каталог</strong></a>
        <label class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"<strong><label style="color: red"><?php if (!empty($out)) {echo "$out";} ?></strong></label>
        </ul>
        <button type="button" class="btn btn-primary my-2 my-sm-0" data-toggle="modal"
                data-target="#staticBackdrop">
            <i class="fas fa-shopping-cart marginright total-count"></i>
            <a class="navbar-brand" href="logout"><strong>Logout </strong></a>
        </button>
        <button type="button" class="btn btn-primary my-2 my-sm-0" data-toggle="modal"
                data-target="#staticBackdrop">
            <i class="fas fa-shopping-cart marginright total-count"></i>
            <a class="navbar-brand" href="cart"><strong>Корзина</strong></a>
        </button>

        </div>
    </nav>
</main>

</body>
</html>
<div class="container">
    <h3>Ваша корзина</h3>
    <div class="card-deck">
        <?php foreach ($cart as $value) {
        $id = $value['product_id'];
        $stmt = $pdo->query("SELECT * FROM products WHERE id = $id");
        $products = $stmt->fetchAll();
        foreach ($products as $product) : ?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                    </div>
                    <img class="card-img-top" src="<?php echo $product['pngadress'];?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php print_r($product['name']);?></p>
                        <a href="#"><h5 class="card-title"><?php print_r($product['description']);?></h5></a>
                        <div class="card-footer">
                            <?php $cell = $product['price']*$value['amount']; print_r("Стоимость товара {$product['price']} рублей");?>
                        </div>
                        <div class="card-footer">
                            <?php print_r("в количестве {$value['amount']} = ".($product['price'])*$value['amount']." рублей");
                            $total = $total + $cell;?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; }?>
    </div>
</div>
<div class="card-footer">
    <?php print_r("итого: ".$total." рублей");?>
</div>


<style>
    body {
        font-style: italic;
        background-image: url("./images/rinok.jpg");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        background-attachment: fixed;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 20rem;
    }

    .card:hover {
        box-shadow: 100px 2px 100px yellow;
        transition: 0.2s;
    }

    .card-header {
        font-size: 20px;
        color: red;
        background-color: blue;
    }

    .text-muted {
        font-size: 20px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 20px;
        background-color: white;
    }
</style>


