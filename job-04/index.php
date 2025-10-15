<?php
require_once '../job-01/Product.php';

$pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = 12;
$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier que la requête a retourné un résultat avant d'accéder aux clés
if ($data === false) {
    die('Produit introuvable (id=' . intval($id) . ')');
}

$product = new Product();
$product->setId($data['id']);
$product->setName($data['name']);
$product->setPhotos(json_decode($data['photos']));
$product->setPrice($data['price']);
$product->setDescription($data['description']);
$product->setQuantity($data['quantity']);
$product->setCreatedAt(new DateTime($data['createdAt']));
$product->setUpdatedAt(new DateTime($data['updatedAt']));
$product->setCategoryId($data['category_id']);
