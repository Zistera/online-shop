<?php
class ProductController
{
    public function getGormOfCatalog()
    {
        require_once './../model/Product.php';
        $product = new Product();
        $products = $product->getProductsForFormOfCatalog();
        require_once "./../view/catalog.php";
    }
}