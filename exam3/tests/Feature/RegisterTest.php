<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 測試路由
     */
    public function testRoute()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * 可以註冊
     */
    public function testCanRigister() 
    {
        $response = $this->post('/register', [
            'name' => 'test user',
            'account' => 'user',
            'password' => 'abc123456789',
            'password_confirmation' => 'abc123456789'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        
        $this->assertDatabaseHas('users', [
            'account' => 'user',
        ]);
    }
}
