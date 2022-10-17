## issue 

**題目二：** 請你設計出購物車的函式庫，至少包含一個以上的物件，此函式庫必須包含以下功能：

欄位資訊：

1. 商品：
    1. 品名、單價、數量、折扣金額、總計金額
2. 優惠折扣：
    1. 優惠名稱、折扣金額

購物車功能：

1. 商品的 CRUD：
    1. 新增商品
    2. 移除商品
    3. 更新商品數量
2. 優惠折扣
    1. 單一品項增加優惠折扣
    2. 單一品項移除優惠折扣
3. 取得購物車內商品清單(顯示品名、數量、單價、折扣金額 & 優惠名稱、結帳金額)
4. 取得購物車總共金額

## 前言

1. install
```bash
composer install
```
2. 範例檔: `sample.php`
3. 因測試關係,無關連資料庫，資料寫死於 Models
    - 10 個商品於 `src/Models/Product`
    - 3 個折扣於 `src/Models/Discount`


## 使用 Cart

```php

use ChihYuLin66\HiskioExamCart\Cart;
$cart = new Cart;

// 顯示購物車品項
$cart->items();

// 計算購物車總計
$cart->total();

/**
 * 計算單品金額
 * 
 * @param int $productId: 商品 ID
 */
$cart->calcItemTotal($productId);

/**
 * 顯示品項索引
 * 
 * @param int $productId: 商品 ID 
 */
$cart->showItemKey($productId);

/**
 * 顯示品項
 * 
 * @param int $productId: 商品 ID 
 */
$cart->showItem($productId);
    
/**
 * 新增項目到購物車
 * 
 * @param int $productId: 商品 ID
 * @param int $quantities: 數量 [default: 1]
 */
$cart->addItem($productId, $quantities = 1);

/**
 * 刪除購物車品項
 * 
 * @param int $productId: 商品 ID
 */
$cart->removeItem($productId);

/**
 * 設定購物車品項數量
 * 
 * @param int $productId: 商品 ID
 * @param int $quantities: 數量
 */
$cart->setItemQuantities($productId, $quantities);

/**
 * 增加品項折扣
 * 
 * @param int $productId: 商品 ID
 * @param int $discountId: 折扣 ID
 */
$cart->addDiscountToItem($productId, $discountId);

/**
 * 移除品項折扣
 * 
 * @param int $productId: 商品 ID
 */
$cart->removeDiscountFromItem($productId);
```

## 測試

```bash
./vendor/bin/phpunit tests
```