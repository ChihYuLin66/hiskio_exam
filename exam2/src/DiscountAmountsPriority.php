<?php

namespace ChihYuLin66\HiskioExamCart;

use ChihYuLin66\HiskioExamCart\Contracts\DiscountPriorityInterface;

/**
 * 折扣金額為優先
 */
class DiscountAmountsPriority implements DiscountPriorityInterface
{
    public function calc($total, $amounts, $percent): int
    { 
        return ($total - $amounts) * $percent;
    }
}
