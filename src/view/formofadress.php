<!DOCTYPE html>
<html lang="en" >
<head>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css'><link rel="stylesheet" href="./style.css">
</head>
<body>

<main>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/catalog"><strong>Вернуться в каталог</strong></a>
        <label class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"<strong><label style="color: red"></strong></label>
        </ul>
        <button type="button" class="btn btn-primary my-2 my-sm-0" data-toggle="modal"
                data-target="#staticBackdrop">
            <i class="fas fa-shopping-cart marginright total-count"></i>
            <a class="navbar-brand" href="/logout"><strong>Logout </strong></a>
        </button>



        </div>
    </nav>
</main>

</body>
</html>
<div class="container">

    <form action="/order" method="POST">

        <h1>Product order page</h1>
        <p>Please fill in this form to order products</p>


        <label for="Name"><b>Full Name</b></label> <label style="color: red">
            <?php if (!empty($errors["name"])){
                print_r($errors["name"]);} ?> </label>
        <input name="Name" placeholder="Enter name" required>

        <label for="Email"><b>Email</b></label> <label style="color: red">
            <?php if (!empty($errors["email"])){
                print_r($errors["email"]);} ?> </label>
        <input name="Email"  placeholder="Enter Email" required>

        <label for="Address"><b>Address</b></label>
        <input name="Address" placeholder="Enter Address"required>

        <label for="Number"><b>Number</b></label> <label style="color: red">
            <?php if (!empty($errors["number"])){
                print_r($errors["number"]);} ?> </label>
        <input name="Number" placeholder="Number" required>

        </br>
        </br>
        </br>

        <div class="grid-container">
            <?php if (!empty($products)) { $i = 0; foreach ($products as $product) : ?>
            <div class="grid-item">
                <a><img src="<?php echo $product['pngadress'];?>" height="200" width="auto" ></a>
            </div>
            <div class="grid-item">
                <h1><?php $cell = $product['price']*$product['amount']; print_r($product['name']);?></h1>
                    <p> <?php print_r($product['price']);?> </p>
            </div>
            <div class="grid-item">
                <label for="NoShoe"><b><?php print_r("в количестве {$product['amount']} = ".($product['price'])*$product['amount']." рублей");
                        $total = $total + $cell; $i++;?></b></label>
            </div>
            <?php endforeach;}?>


            </br>



        </div>



        <input type="submit" value="Завершить покупку" class="submitbtn"/>
    </form>



</div>





<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        background-color: black;
    }

    * {
        box-sizing: border-box;
    }


    .container {
        padding: 150px;
        font-size: 20px;
        background-color: white;
    }

    /* Full-width input fields */
    input[Name], input[Name] {
        width: 100%;
        padding: 15px;
        margin: 5px 10px 22px 22px;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .submitbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        width: 100%;
        opacity: 0.9;
        text-size: 20px;
    }
<?php
$auto = " auto";
while ($i>=0)
{
    $auto = $auto . $auto;
    $i--;
}
?>
    .grid-container {
        display: grid;
        grid-template-columns: auto <?php echo $auto; ?>;
        padding: 10px;
    }
    .grid-item {

        padding: 20px;
        font-size: 10px;
        text-align: center;
    }
</style>
