<?php
namespace Chihyulin66\HiskioExamCart\Handlers;

class DiscountHandler
{

    /**
     * 計算折扣後的金額
     * 
     * @param Discount $discount
     * @param int $total: 預計算的總計
     */
    public function calc($discount, $total)
    {
        if (!$discount->amount) {
            $discount->amount = 0;
        }

        if (!$discount->percent) {
            $discount->percent = 1;
        }
        
        switch ($discount->priority) {
            case 'amount':
                return (new DiscountAmountsPriority)->calc($total, $discount->amount, $discount->percent);
            case 'percent':
                return (new DiscountPercentPriority)->calc($total, $discount->amount, $discount->percent);
            default:
                throw new RuntimeException("Not supported type: {$discount->priority}");
        }
    }
}