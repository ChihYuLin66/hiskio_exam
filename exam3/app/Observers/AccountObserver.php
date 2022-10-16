<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Account;

class AccountObserver
{
    /**
     * Handle the account "creating" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function creating(Account $account)
    {
        // 避免沒計算到，自動計算
        if (!$account->balance) {
            $user = User::find($account->user_id);
            $account->balance = $user->balance + $account->amount;
        }
    }
}
