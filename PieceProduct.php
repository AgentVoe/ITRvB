<?php
require_once 'Product.php';
class PieceProduct extends Product {
    public function calculateFinalCost($quantity): float {
        return $this->price * $quantity;
    }
}

?>