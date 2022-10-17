<?php

declare(strict_types=1);

namespace ChihYuLin66\HiskioExamCart\Tests;

use PHPUnit\Framework\TestCase;
use ChihYuLin66\HiskioExamCart\Cart;
use ChihYuLin66\HiskioExamCart\Models\Product;
use ChihYuLin66\HiskioExamCart\Models\Discount;
use ChihYuLin66\HiskioExamCart\Handlers\DiscountHandler;

class CartTest extends TestCase
{
    /**
     * 顯示品項
     */
    public function testShowItem() 
    {
        $cart = new Cart();  
        $cart->addItem(1);

        $item = $cart->showItem(1);
        $product = Product::find(1);

        $this->assertEquals($item['productId'], $product->id);
    }

    /**
     * 新增品項
     */
    public function testAddItem() 
    {
        $cart = new Cart();

        // 成功加入商品
        $this->assertEmpty($cart->items());
        $cart->addItem(1);
        $this->assertNotEmpty($cart->items());

        // 商品數量正確為預設的 1
        $item = $cart->showItem(1);
        $this->assertEquals(1, $item['quantities']);

        // 可疊加
        $cart->addItem(1, 2);
        $item = $cart->showItem(1);
        $this->assertEquals(3, $item['quantities']);
    }
    
    /**
     * 移除品項
     */
    public function testRemoveItem() 
    {
        $cart = new Cart();

        // 加入商品 再刪除
        $this->assertEmpty($cart->items());
        $cart->addItem(1);
        $cart->removeItem(1);
        $this->assertEmpty($cart->items());
    }
    
    /**
     * 購物車品項
     */
    public function testItems() 
    {
        $cart = new Cart();  
        $cart->addItem(1);

        $this->assertCount(1, $cart->items());
    }

    /**
     * 變更品項數量
     * 
     */
    public function testSetItemQuantities() 
    {
        $cart = new Cart();

        $cart->addItem(1);
        $cart->setItemQuantities(1, 300);       
        $item = $cart->showItem(1);
        $this->assertEquals(300, $item['quantities']);
    }

    /**
     * 增加品項折扣
     */
    public function testAddDiscountToItem() 
    {
        $productId = 1;
        $discountId = 1;
        $quantities = 10;
        $cart = new Cart();

        $cart->addItem(1, $quantities);
        $cart->addDiscountToItem($productId, $discountId);
        
        // 試算
        $product = Product::find($productId);
        $discount = Discount::find($discountId);

        $this->assertEquals(
            $cart->calcItemTotal($productId), 
            (new DiscountHandler)->calc($discount, $quantities * $product->price)
        );
    }

    /**
     * 刪除品項折扣
     */
    public function testRemoveDiscountFromItem() 
    {
        $productId = 1;
        $discountId = 1;
        $quantities = 10;
        $cart = new Cart();

        $cart->addItem(1, $quantities);
        $cart->addDiscountToItem($productId, $discountId);
        $cart->removeDiscountFromItem($productId);
        
        // 試算
        $product = Product::find($productId);
        
        $this->assertEquals(
            $cart->calcItemTotal($productId), 
            $quantities * $product->price
        );
    }
    
    /**
     * 檢視統計
     */
    public function testTotal() 
    {
        $this->assertTrue(true);

        // let me think...
        
        // $cart = new Cart();
    }
    
}