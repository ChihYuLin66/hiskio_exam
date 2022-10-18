## issue 

### 題目三

請您使用 Laravel 建立一個 API 系統，此系統需具備以下功能：

1. 會員登入、註冊，至少需 account, password 欄位。

2. 帳戶存款的 CRUD 功能，至少需 user_id, balance 欄位。

畫面不需特別進行美化，至少需簡單呈現以下資料，其他資料可自行評估後增加！

/accounts

| 用戶 ID | 帳號 | 存款金額 | 詳細資料 |
| --- | --- | --- | --- |
| 1 | aaa | 100 | a link -> /accounts/1 |

/accounts/1

| 金額 | 存款金額 | 日期 |
| --- | --- | --- |
| 100 | 100 | 2022/05/01 |
| -100 | 0 | 2022/05/02 |
| 50 | 50 | 2022/05/03 |

**切記：每人的帳戶存款不能為負值**

---

## 前言

1. 使用版本
    -  Laravel: 7
    -  PHP: 7.3
    -  npm: 6.14.12
    -  node: 12.22.1

2.  初始化
    ```bash
    cp .env.example .env
    cp .env.example .env.testing
    php artisan key:generate
    composer install
    npm install
    npm run dev
    ```

3. env 設定 
    - 新增: 單元測試用的資料庫設定
        ```
        DB_TEST_CONNECTION=mysql
        DB_TEST_HOST=127.0.0.1
        DB_TEST_PORT=3306
        DB_TEST_DATABASE=laravel_testing
        DB_TEST_USERNAME=root
        DB_TEST_PASSWORD=
        ```

4. 資料表
    ```bash
    php artisan migrate
    ```

5. 若需要測試的帳號  
    ```bash
    php artisan db:seed
    ```
    > 帳號:`user` ， 密碼: `123456`

## 測試

```bash
php artisan test
```