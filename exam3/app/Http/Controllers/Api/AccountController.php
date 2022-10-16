<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request) 
    {
        $records = Auth::user()->accounts()
            ->latest('created_at')
            ->get()
            ->map(function($record) {
                return [
                    'amount' => $record->amount,
                    'balance' => $record->balance,
                    'created_at' => $record->created_at->format('Y-m-d H:i'),
                ];
            });
        
        $data['records'] = $records;
           
        return response()
            ->json([
                'status'   => true,
                'message'  => 'success',
                'data'	   => $data,
            ], '200');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $record = $user->accounts()
            ->create([
                'amount' => $request->amount,
                'balance' => $user->balance + $request->amount
            ]);
        
        $data['record'] = $record;
        
        return response()
            ->json([
                'status'   => true,
                'message'  => 'success',
                'data'	   => $data,
            ], '200');
        
    }

   
}
