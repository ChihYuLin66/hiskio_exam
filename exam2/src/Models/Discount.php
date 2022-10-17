<?php

namespace ChihYuLin66\HiskioExamCart\Models;

use Exception;

class Discount
{
    private static $discounts = [   
        // only amounts
        1 => ['id' => 1, 'name' => 'discount1', 'priority' => 'amounts', 'amounts' => 100, 'percent' => 1],

        // only percent 
        2 => ['id' => 2, 'name' => 'discount2', 'priority' => 'amounts', 'amounts' => 0, 'percent' => 0.9],

        // amounts first 
        3 => ['id' => 3, 'name' => 'discount3', 'priority' => 'amounts', 'amounts' => 100, 'percent' => 0.9],

        // percent first
        4 => ['id' => 4, 'name' => 'discount4', 'priority' => 'percent', 'amounts' => 100, 'percent' => 0.9],
    ];

    public static function find($id)
    {
        if (empty(self::$discounts[$id])) {
            throw new Exception("not found id: {$id}");
        }
        
        return (object)self::$discounts[$id];
    }
}
