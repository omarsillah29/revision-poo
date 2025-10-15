<?php
require_once __DIR__ . '/../job-01/Product.php';
require_once __DIR__ . '/../job-02/Category.php';

$pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer une catégorie
$category = new Category(2, 'Électronique', 'Appareils et gadgets');

// Récupérer les produits associés
$products = $category->getProducts($pdo);

foreach ($products as $product) {
    echo $product->getName() . '<br>';
}
