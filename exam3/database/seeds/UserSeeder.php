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
        // for test
        User::create([
            'name' => 'Dan',
            'account' => 'dan',
            'password' => Hash::make(123456),
        ]);
    }
}
