<?php
require_once __DIR__ . '/Clothing.php';
require_once __DIR__ . '/Electronic.php';

// Demo : AbstractProduct cannot be instantiated
// $p = new AbstractProduct(); // <-- would error

$c = new Clothing(0, 'T-shirt demo', [], 1999, 'Un t-shirt', 3, 'M', 'Bleu');
$c->create();

$e = new Electronic(0, 'Casque demo', [], 4999, 'Un casque', 2, 'Acme', 12);
$e->create();

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Job-13 Demo</title>
</head>

<body>
    <h1>Job-13: démonstration AbstractProduct</h1>
    <h2>Clothings</h2>
    <?php foreach (Clothing::findAll() as $item): ?>
        <div>
            <?= htmlspecialchars($item->getName()); ?> - Size: <?= htmlspecialchars($item->getSize()); ?>
        </div>
    <?php endforeach; ?>

    <h2>Electronics</h2>
    <?php foreach (Electronic::findAll() as $item): ?>
        <div>
            <?= htmlspecialchars($item->getName()); ?> - Brand: <?= htmlspecialchars($item->getBrand()); ?>
        </div>
    <?php endforeach; ?>
</body>

</html>