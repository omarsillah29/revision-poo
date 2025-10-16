<?php

require_once '../job-01/Product.php';
require_once '../job-02/Category.php';

$pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$product = new Product(
    0,
    'T-shirt',
    ['https://picsum.photos/200/300'],
    1000,
    'A beautiful T-shirt',
    10,
    new DateTime(),
    new DateTime(),
    1 // id de la catégorie
);

$result = $product->create();

if ($result !== false) {
    echo "Produit inséré avec l'ID : " . $product->getId();
} else {
    echo "Échec de l'insertion.";
}
