<?php
require_once 'Product.php';
class ElectronicProduct extends Product {
    public int $warranty;

    public function __construct(string $name, float $price, string $description, int $stock, int $warranty) {
        parent::__construct($name, $price, $description, $stock);
        $this->warranty = $warranty;
    }

    public function getWarrantyInfo(): string {
        return "Гарантия: {$this->warranty} месяцев";
    }
}
    
?>

Различия классов: Products и ElectronicProducts:
Products класс представляет базовую сущность продукта, с общими характеристиками. 
ElectronicProduct класс расширяет функциональность Product, добавляя специфическое для электроники свойство - гарантия