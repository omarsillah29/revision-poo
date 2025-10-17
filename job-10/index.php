<?php

require_once '../job-01/Product.php';
require_once '../job-02/Category.php';

$pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$productModel = new Product();
$products = $productModel->findAll($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id']; // ID du produit à mettre à jour
    $name = $_POST['name'];
    $price = (int)$_POST['price'];
    $description = $_POST['description'];
    $quantity = (int)$_POST['quantity'];
    $image = $_POST['image'];


    // Charger le produit existant
    $product = new Product();
    $product = $product->findOneById($id, $pdo);

    if ($product !== false) {
        $product->setName($name);
        $product->setPrice($price);
        $product->setDescription($description);
        $product->setQuantity($quantity);
        $product->setPhotos([$image]);
        $product->setUpdatedAt(new DateTime());

        $product->update(); // Met à jour le produit

        echo "Produit mis à jour avec succès.";
    } else {
        echo "Produit introuvable.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mettre à jour un produit</title>
</head>

<body>
    <h1>Modifier un produit existant</h1>
    <form method="post">
        <label for="id">Choisir un produit à modifier :</label><br>
        <select name="id" id="id" required>
            <?php foreach ($products as $p): ?>
                <option value="<?= $p->getId(); ?>">
                    <?= $p->getId(); ?> - <?= htmlspecialchars($p->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="name">Nom du produit :</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Prix (en centimes) :</label><br>
        <input type="number" id="price" name="price" required><br><br>

        <label for="description">Description :</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="quantity">Quantité :</label><br>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <label for="image">URL de l’image :</label><br>
        <input type="text" id="image" name="image" required><br><br>

        <input type="submit" value="Mettre à jour le produit">
    </form>

</body>

</html>