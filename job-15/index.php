<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Clothing;
use App\Electronic;

$e = new Electronic(2, 'Casque', 2, 'Acme');
$c = new Clothing(1, 'T-shirt', 5, 'M', 'Bleu');


$c->addStocks(10)->removeStocks(3);
$e->addStocks(5)->removeStocks(1)->addStocks(2);

echo "Clothing qty: " . $c->getQuantity() . "\n";
echo "Electronic qty: " . $e->getQuantity() . "\n";
