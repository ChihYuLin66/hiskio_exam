<?php

namespace ChihYuLin66\HiskioExamCart;

use ChihYuLin66\HiskioExamCart\Contracts\DiscountPriorityInterface;

/**
 * 折扣折數為優先
 */
class DiscountPercentPriority implements DiscountPriorityInterface 
{
    public function calc($total, $amounts, $percent): int
    { 
        return $total * $percent - $amounts;
    }
}
