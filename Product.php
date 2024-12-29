<?php

abstract class Product {
    protected string $name;
    protected float $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function calculateFinalCost($quantity): float;
}

?>