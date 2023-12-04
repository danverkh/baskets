<?php

use Controller\BasketController;
use Entity\Product;

require_once "vendor/autoload.php";

$widgetRed = new Product();
$widgetRed->setName('Red Widget');
$widgetRed->setCode('R01');
$widgetRed->setPrice(32.95);

$widgetGreen = new Product();
$widgetGreen->setName('Green Widget');
$widgetGreen->setCode('G01');
$widgetGreen->setPrice(24.95);

$widgetBlue = new Product();
$widgetBlue->setName('Blue Widget');
$widgetBlue->setCode('B01');
$widgetBlue->setPrice(7.95);

$products = [$widgetRed, $widgetGreen, $widgetBlue];

$deliveryRules = [
    90 => 0,    // Free delivery for orders of $90 or more
    50 => 2.95, // Delivery costs $2.95 for orders under $90 but over $50
    0  => 4.95, // Delivery costs $4.95 for orders under $50
];

$offers = [
    'R01' => 'BOGO50', // Buy one red widget, get the second half price
];

$basket = new BasketController($products, $deliveryRules, $offers);

$basket->add($widgetBlue);
$basket->add($widgetGreen);
echo 'Total: $' . $basket->total() . PHP_EOL; // Expected: $37.85
$basket->clear();

$basket->add($widgetRed);
$basket->add($widgetRed);
echo 'Total: $' . $basket->total() . PHP_EOL; // Expected: $54.37
$basket->clear();

$basket->add($widgetRed);
$basket->add($widgetGreen);
echo 'Total: $' . $basket->total() . PHP_EOL; // Expected: $60.85
$basket->clear();

$basket->add($widgetBlue);
$basket->add($widgetBlue);
$basket->add($widgetRed);
$basket->add($widgetRed);
$basket->add($widgetRed);
echo 'Total: $' . $basket->total() . PHP_EOL; // Expected: $98.27
$basket->clear();