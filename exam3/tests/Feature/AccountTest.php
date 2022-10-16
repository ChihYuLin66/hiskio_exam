<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * 測試路由, 未登入
     */
    public function testRoute()
    {
        $response = $this->get('/accounts/1');
        $this->assertGuest();
    }

    /**
     * 測試路由, 已登入
     */
    public function testRouteWithAuth()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');
        
        $response = $this->get('/accounts/' . $user->id);
        $response->assertStatus(200);
    }

    /**
     * 取得帳號紀錄
     */
    public function testGetAccountRecords()
    {
        $user = factory(User::class)->create();
        $accountRecords = 3;
        for ($i=1; $i <= $accountRecords; $i++) { 
            $fakerAmount = $this->faker->numberBetween(1, 150) * 10;
            $user->accounts()->create([
                'user_id'=> $user->id,
                'amount' => $fakerAmount,
                'balance' => $user->balance + $fakerAmount
            ]);
        }
        $this->actingAs($user, 'web');
        $response = $this->get('/api/user/accounts');
        $response->assertStatus(200);

        $this->assertEquals(Account::where('user_id', $user->id)->count(), $accountRecords);
    }

    /**
     * 加入紀錄至帳號
     */
    public function testStoreAccountRecord()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');

        $response = $this->post('/api/user/accounts', [
            'amount' => 100
        ]);
        $response->assertStatus(200);

        $responseContent = json_decode($response->getContent(), true);
        $this->assertTrue($responseContent['status']);
    }

    /**
     * 加入紀錄至帳號 validation
     */
    public function testStoreAccountRecordValidation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');
        
        // 正常的值
        $response = $this->post('/api/user/accounts', [
            'amount' => 100
        ]);
        $response->assertStatus(200);
        $responseContent = json_decode($response->getContent(), true);
        $this->assertTrue($responseContent['status']);

        // required
        $response = $this->post('/api/user/accounts');
        $response->assertStatus(200);
        $responseContent = json_decode($response->getContent(), true);
        $this->assertEquals($responseContent['status'], false);

        // numeric
        $response = $this->post('/api/user/accounts', [
            'amount' => '一百'
        ]);
        $response->assertStatus(200);
        $responseContent = json_decode($response->getContent(), true);
        $this->assertEquals($responseContent['status'], false);
    }

    /**
     * 加入紀錄至帳號 確認餘額
     */
    public function testStoreAccountRecordCheckBalance()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');

        $response = $this->post('/api/user/accounts', [
            'amount' => 100
        ]);

        $user = User::find($user->id);
        $this->assertEquals($user->balance, 100);
    }

    /**
     * 加入紀錄至帳號 不可低於0
     */
    public function testStoreAccountRecordCantLowerThanZero()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');

        $response = $this->post('/api/user/accounts', [
            'amount' => -100
        ]);
        $response->assertStatus(200);
        $responseContent = json_decode($response->getContent(), true);
        $this->assertEquals($responseContent['status'], false);
    }

}
