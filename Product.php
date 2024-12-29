<?php

class Product {
    public string $name;
    public float $price;
    public string $description;
    public int $stock;

    public function __construct(string $name, float $price, string $description, int $stock) {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->stock = $stock;
    }

    public function getDetails(): string {
        return "Название: {$this->name}, Цена: {$this->price}, Описание: {$this->description}, Остаток: {$this->stock}";
    }

    public function updateStock(int $quantity): void {
        $this->stock += $quantity;
    }
}

?>