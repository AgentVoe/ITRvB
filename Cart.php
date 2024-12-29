<?php

class Cart {
    public array $items = [];

    public function addItem(Product $product, int $quantity): void {
        $this->items[] = [
            'product' => $product,
            'quantity' => $quantity
        ];
    }

    public function getTotalPrice(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->price * $item['quantity'];
        }
        return $total;
    }
}

?>