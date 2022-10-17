<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use ChihYuLin66\HiskioExamCart\Cart;

$cart = new Cart();

// add item to cart
$cart->addItem(1);
$cart->addItem(2);
$cart->addItem(3, 5);

// 同樣商品再加一次
$cart->addItem(2);

// 刪除商品
$cart->removeItem(2);

// 設定品項數量
$cart->setItemQuantities(3, 6);


// addDiscountToItem
$cart->addDiscountToItem(1, 1);

// 再加一次
try {
    $cart->addDiscountToItem(1, 1);
} catch (\Throwable $th) {
    echo $th->getMessage();
}

$cart->removeDiscountFromItem(1);

// 再刪一次
try {
    $cart->removeDiscountFromItem(1);
} catch (\Throwable $th) {
    echo $th->getMessage();
}

$cart->addDiscountToItem(3, 3);


echo '<xmp>

### 購物車項目:
';
print_r($cart->items());

echo '


### 總計: $ ' . number_format($cart->total());
echo '</xmp>';
