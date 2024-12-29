<?php

require_once 'DigitalProduct.php';
require_once 'PieceProduct.php';
require_once 'WeightProduct.php';

$digital = new DigitalProduct("Электронная книга", 500);
$piece = new PieceProduct("Ноутбук", 30000);
$weight = new WeightProduct("Яблоки", 100);

echo "Доход от цифрового товара: " . $digital->calculateFinalCost(2) . " руб.<br>";
echo "Доход от штучного товара: " . $piece->calculateFinalCost(3) . " руб.<br>";
echo "Доход от весового товара: " . $weight->calculateFinalCost(5) . " руб.<br>";

?>