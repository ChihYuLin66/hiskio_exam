<?php

namespace ChihYuLin66\HiskioExamCart;

use ChihYuLin66\HiskioExamCart\Models\Product;
use ChihYuLin66\HiskioExamCart\Models\Discount;
use ChihYuLin66\HiskioExamCart\Exceptions\CartException;
use ChihYuLin66\HiskioExamCart\Handlers\DiscountHandler;

class Cart
{
    private $cartItems = [];

    /**
     * 購物車品項
     */
    public function items(): array
    {
        return $this->cartItems;
    }

    /**
     * 購物車總計
     */
    public function total(): int
    {
        $total = 0;
        foreach ($this->cartItems as $key => $item) {
            $total += $this->calcItemTotal($item['productId']);
        }
        
        return $total;
    }

    /**
     * 計算單品金額
     * 
     * @param int $productId: 商品 ID
     */
    private function calcItemTotal($productId): int
    {
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];
        $total = $item['price'] * $item['quantities'];

        // 折扣
        if (!empty($item['discountId'])) {
            $discount = Discount::find($item['discountId']);
            $total = (new DiscountHandler)->calc($discount, $total);
        }

        return $total;
    }

    /**
     * 設定計算單品金額
     * 
     * @param int $productId: 商品 ID
     */
    private function setItemTotal($productId): void
    {
        
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];
        $total = $item['price'] * $item['quantities'];

        // 折扣
        if (!empty($item['discountId'])) {
            $discount = Discount::find($discountId);
            $total = (new DiscountHandler)->calc($discount, $total);
        }

        $this->cartItems[$itemKey]['total'] = $total;
    }

    /**
     * 尋找品項
     * 
     * @param int $productId: 商品 ID 
     */
    public function showItem($productId): int
    {
        foreach ($this->cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                return $key;
            }
        }
        
        throw new CartException('查無品項');
    }
    
    /**
     * 新增項目到購物車
     * 
     * @param int $productId: 商品 ID
     * @param int $quantities: 數量
     */
    public function addItem($productId, $quantities = 1): void
    {
        // 若商品已在購物車，找出商品並加上數量。
        $existKey = null;
        foreach ($this->cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                $existKey = $key;
                break;
            }
        }

        if ($existKey) {

            $this->cartItems[$existKey]['quantities'] += $quantities;
        } else {

            // 新增品項
            $product = Product::find($productId);

            $this->cartItems[] = [
                'productId' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantities' => $quantities,
                'discountId' => null,
                'discountName' => null,
                'total' => 0,
            ];
        }

        $this->setItemTotal($productId);
    }

    /**
     * 刪除購物車品項
     * 
     * @param int $productId: 商品 ID
     */
    public function removeItem($productId): void
    {
        $itemKey = $this->showItem($productId);

        unset($this->cartItems[$itemKey]);
    }

    /**
     * 設定購物車品項數量
     * 
     * @param int $productId: 商品 ID
     * @param int $quantities: 數量
     */
    public function setItemQuantities($productId, $quantities): void
    {
        $itemKey = $this->showItem($productId);
        $this->cartItems[$itemKey]['quantities'] = $quantities;
    }

    /**
     * 增加品項折扣
     * 
     * @param int $productId: 商品 ID
     * @param int $discountId: 折扣 ID
     */
    public function addDiscountToItem($productId, $discountId): void
    {
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];

        if (!empty($item['discountId'])) {
            throw new CartException('已使用優惠折扣，無法加入優惠折扣');
        }

        $discount = Discount::find($discountId);
        $this->cartItems[$itemKey]['discountId'] = $discount->id;
        $this->cartItems[$itemKey]['discountName'] = $discount->name;
        $this->cartItems[$itemKey]['total'] = $this->calcItemTotal($productId);
    }

    /**
     * 移除品項折扣
     * 
     * @param int $productId: 商品 ID
     */
    public function removeDiscountFromItem($productId): void
    {
        $itemKey = $this->showItem($productId);
        $item = $this->cartItems[$itemKey];

        if (empty($item['discountId'])) {
            throw new CartException('無折扣，無需移除折扣');
        }

        $this->cartItems[$itemKey]['discountId'] = null;
        $this->cartItems[$itemKey]['discountName'] = null;
        $this->cartItems[$itemKey]['total'] = $this->calcItemTotal($productId);
    }
}
