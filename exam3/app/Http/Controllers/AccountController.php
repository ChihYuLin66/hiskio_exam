<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccountController extends Controller
{
    public function show(Request $reqest, User $user)
    {
        Gate::authorize('user-view', $user);

        return view('accounts.show', compact('user'));
    }
}
