<?php

namespace Chihyulin66\HiskioExamCart\Contracts;

interface DiscountPriorityInterface {

    /**
     * 計算折扣後的金額
     * 
     * @param int $total: 總金額
     * @param int $amount: 折扣金額
     * @param int $percent: 折扣百分比
     */
    public function clac($total, $amount, $percent): int;
}