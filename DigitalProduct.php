<?php
require_once 'Product.php';
class DigitalProduct extends Product {
    public function calculateFinalCost($quantity): float {
        return ($this->price / 2) * $quantity;
    }
}

?>