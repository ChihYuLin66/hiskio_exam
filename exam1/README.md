## issue 

問題一：
一層樓梯，一次爬一層：1 種方式
二層樓梯，一次爬一層，或是一次爬兩層：2 種方式
三層樓梯，一次爬一層，先爬兩層再一層，或先爬一層再兩層：3 種方式

現在有 N 層樓梯，總共有多少種爬樓梯的方式？需要你用程式寫出我輸入 N 之後回傳一個數字（幾種方式）

## 前言

1. install
```bash
composer install
```
2. 範例檔: `sample.php`

## 使用

- 只有一個 class 與 一個 function
```php
use ChihYuLin66\HiskioExamClimbStair\ClimbStair;
$climbStair = new ClimbStair(); 

/**
 * 爬階梯的主要函式 
 * @param int $n: 總階梯數量
 * 
 * @return array
 */
$climbStair->climb($n);
```
> 回傳的 array 中 `all` 為全部可能, `count` 為可能的總數量

## 測試

```bash
./vendor/bin/phpunit tests
```