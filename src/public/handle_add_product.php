<?php
session_start();
$userdata = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$amount = $_POST['amount'];
//добавить валидацию

$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo->prepare("INSERT INTO user_products(user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
$stmt->execute(['user_id' => $userdata, 'product_id' => $product_id, 'amount' => $amount]);

$stmt = $pdo->prepare("SELECT * FROM products WHERE $product_id = :id ");
$stmt->execute(['id' => $product_id]);
$products = $stmt->fetchAll();

$total = 0;
?>
<div class="container">
    <h3>Ваша корзина</h3>
    <div class="card-deck">
        <?php foreach ($products as $product) : ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                </div>
                <img class="card-img-top" src="<?php echo $product['pngadress'];?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php print_r($product['name']);?></p>
                    <a href="#"><h5 class="card-title"><?php print_r($product['description']);?></h5></a>
                    <div class="card-footer">
                        <?php print_r("{$product['price']} рублей");?>
                    </div>
                    <div class="card-footer">
                        <?php print_r("в количестве {$amount} = ".($product['price'])*$amount." рублей");
                        $total = $total + (($product['price'])*$amount)?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="card-footer">
    <?php print_r("итого: ".$total." рублей");?>
</div>


<style>
    body {
        font-style: italic;
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
