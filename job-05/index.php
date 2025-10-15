<?php
require_once '../job-01/Product.php';
require_once '../job-02/Category.php';

$pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer le produit avec id = 7
$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([7]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Hydrater le produit
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

// Récupérer la catégorie associée
$category = $product->getCategory($pdo);
echo "Catégorie : " . $category->getName();
