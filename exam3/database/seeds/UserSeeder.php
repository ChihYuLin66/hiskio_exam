<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if (User::where('account', 'user')->count() == 0) {
            // for test
            User::create([
                'name' => 'UserTest',
                'account' => 'user',
                'password' => Hash::make(123456),
            ]);
        }
    }
}
