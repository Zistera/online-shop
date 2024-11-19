<?php
if (!isset($_COOKIE['user_id'])) {
    header('Location: /get_login.php');
}
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchall();
?>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product) : ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src="<?php echo $product['pngadress'];?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php print_r($product['name']);?></p>
                    <a href="#"><h5 class="card-title"><?php print_r($product['description']);?></h5></a>
                    <div class="card-footer">
                        <?php print_r($product['price']);?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
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
