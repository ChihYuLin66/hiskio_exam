<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 測試路由
     */
    public function testRoute()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * 可登入
     */
    public function testCanLogin()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'account' => $user->account,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }


    /**
     * 不可登入, 錯誤的密碼
     */
    public function testWrongPassword()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'account' => $user->account,
            'password' => '123',
        ]);
        
        $this->assertGuest();
    }

}
