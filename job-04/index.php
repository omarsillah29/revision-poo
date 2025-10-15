<?php
$pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = 7;
$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

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

var_dump($product);
