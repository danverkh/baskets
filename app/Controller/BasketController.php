<?php

namespace Controller;

use Entity\Product;

class BasketController
{
    private array $productCatalog;
    private array $deliveryRules;
    private array $offers;
    private array $products = [];

    public function __construct($productCatalog, $deliveryRules, $offers)
    {
        $this->productCatalog = $productCatalog;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    public function total()
    {
        $totalCost = 0;

        // Calculate total cost based on items in the basket
        foreach ($this->products as $product) {
            $totalCost += $product->getPrice();
        }

        // Apply special offers
        $redWidgetCount = array_count_values(array_map(function ($product) {
            return $product->getCode();
        }, $this->products))['R01'] ?? 0;
        $totalCost -= floor($redWidgetCount / 2) * ($this->productCatalog[0]->getPrice() / 2);

        // Apply delivery charge rules
        $deliveryCharge = $this->calculateDeliveryCharge($totalCost);
        $totalCost += $deliveryCharge;

        return floor(($totalCost * 100)) / 100;
    }

    public function clear()
    {
        $this->products = [];
    }

    private function calculateDeliveryCharge($totalAmountSpent)
    {
        foreach ($this->deliveryRules as $threshold => $charge) {
            if ($totalAmountSpent >= $threshold) {
                return $charge;
            }
        }

        return 0; // Free delivery for amounts not covered by delivery rules
    }
}