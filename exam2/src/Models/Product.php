<?php

namespace ChihYuLin66\HiskioExamCart\Models;

use Exception;

class Product 
{
    private static $products = [
        1 => ['id' => 1, 'name' => 'product1', 'price' => 200],
        2 => ['id' => 2, 'name' => 'product2', 'price' => 300],
        3 => ['id' => 3, 'name' => 'product3', 'price' => 560],
        4 => ['id' => 4, 'name' => 'product4', 'price' => 1000],
        5 => ['id' => 5, 'name' => 'product5', 'price' => 3620],
        6 => ['id' => 6, 'name' => 'product6', 'price' => 600],
        7 => ['id' => 7, 'name' => 'product7', 'price' => 320],
        8 => ['id' => 8, 'name' => 'product8', 'price' => 150],
        9 => ['id' => 9, 'name' => 'product9', 'price' => 300],
        10=> ['id' => 10,'name' => 'product10', 'price' => 960],
    ];

    public static function find($id)
    {
        if (empty(self::$products[$id])) {
            throw new Exception("not found id: {$id}");
        }

        return (object)self::$products[$id];
    }
}
