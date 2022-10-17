<?php
namespace ChihYuLin66\HiskioExamCart\Handlers;

use RuntimeException;
use ChihYuLin66\HiskioExamCart\DiscountAmountsPriority;
use ChihYuLin66\HiskioExamCart\DiscountPercentPriority;

class DiscountHandler
{
    /**
     * 計算折扣後的金額
     * 
     * @param ChihYuLin66\HiskioExamCart\Models\Discount $discount
     * @param int $total: 預計算的總計
     * 
     * @return int
     */
    public function calc($discount, $total)
    {
        if (!$discount->amounts) {
            $discount->amounts = 0;
        }

        if (!$discount->percent) {
            $discount->percent = 1;
        }
        
        switch ($discount->priority) {
            case 'amounts':
                return (new DiscountAmountsPriority)->calc($total, $discount->amounts, $discount->percent);
            case 'percent':
                return (new DiscountPercentPriority)->calc($total, $discount->amounts, $discount->percent);
            default:
                throw new RuntimeException("Not supported type: {$discount->priority}");
        }
    }
}