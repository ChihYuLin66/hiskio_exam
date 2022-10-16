<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Model
 */
class Product
{

}

/**
 * Model
 */
class Discount
{

}

/**
 * discount helper
 */
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

interface DiscountPriority {

    public function clac(): int;
}

/**
 * 折扣金額為優先
 */
class DiscountAmountsPriority implements DiscountPriority
{
    public function clac($total, $amount, $percent) 
    { 
        return ($total - $amount) * $percent;
    }
}

/**
 * 折扣折數為優先
 */
class DiscountPercentPriority implements DiscountPriority 
{
    public function clac($total, $amount, $percent) 
    { 
        return $total * $percent - $amount;
    }
}

class CartException extends Exception { 

}

class Cart
{
    private $cartItems;

    /**
     * 購物車總計
     */
    public function total()
    {
        $total = 0;
        foreach ($cartItems as $key => $item) {
            $total += $this->calcItemTotal($item['productId']);
        }
        
        return $total;
    }

    /**
     * 計算單品金額
     */
    private function calcItemTotal($productId)
    {
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];
        $total = $item['price'] * $item['quantities'];

        // 折扣
        if (!empty($item['discountId'])) {
            $discount = Discount::find($discountId);
            $total = (new DiscountHandler)->calc($discount, $total);
        }

        return $total;
    }

    /**
     * 尋找品項
     */
    public function showItem($productId)
    {
        foreach ($cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                return $key;
            }
        }
        
        throw new CartException('查無品項');
    }
    
    /**
     * 新增項目到購物車
     */
    public function addItem($productId) 
    {
        $product = Product::find($productId);

        $this->cartItems[] = [
            'productId' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantities' => $product->price,
            'discountId' => null,
            'total' => $this->calcItemTotal($productId),
        ];
    }

    /**
     * 刪除購物車品項
     */
    public function removeItem($productId) 
    {
        $itemKey = $this->showItem($productId);

        unset($this->cartItems[$itemKey]);
    }

    /**
     * 設定購物車品項數量
     */
    public function setItemQuantities($productId, $quantities) 
    {
        $itemKey = $this->showItem($productId);
        $this->cartItems[$itemKey]['quantities'] = $quantities;
    }

    /**
     * 增加品項折扣
     */
    public function addDiscountToItem($productId, $discountId)
    {
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];

        if (!empty($item['discountId'])) {
            throw new CartException('已使用優惠折扣，無法加入優惠折扣');
        }

        $this->cartItems[$itemKey]['discountId'] = $discountId;
        $this->cartItems[$itemKey]['total'] = $this->calcItemTotal($productId);
    }

    /**
     * 移除品項折扣
     */
    public function removeDiscountFromItem($productId) 
    {
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];

        if (empty($item['discountId'])) {
            throw new CartException('無折扣，無需移除折扣');
        }

        $this->cartItems[$itemKey]['discountId'] = null;
        $this->cartItems[$itemKey]['total'] = $this->calcItemTotal($productId);
    }
}


