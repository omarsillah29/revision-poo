<?php
require_once '../job-01/Product.php';
require_once '../job-02/Category.php';

$pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$products = Product::findAll($pdo);

foreach ($products as $product) {
    echo $product->getName() . '<br>';
}
