<?php
require_once 'Product.php';
class WeightProduct extends Product {
    public function calculateFinalCost($quantity): float {
        return $this->price * $quantity;
    }
}

?>