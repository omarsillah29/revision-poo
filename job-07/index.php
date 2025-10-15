<?php
require_once __DIR__ . '/../job-01/Product.php';
$pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$product = new Product();
$result = $product->findOneById(7, $pdo);

if ($result === false) {
    echo "Produit introuvable.";
} else {
    echo "Produit : " . $product->getName();
}
