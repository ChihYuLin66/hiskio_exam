<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        // 資料驗證
        $validator =  Validator::make($request->toArray(), [
            'amount' => ['required', 'numeric'],
        ]);
        if($validator->fails()) {
            return response()
                ->json([
                    'status'   => false,
                    'message'  => '資料格式錯誤',
                    'data'	   => $validator->errors(),
                ], '200');
        }

        $user = Auth::user();
        $balance = $user->balance + $request->amount;

        // 低於0
        if ($balance < 0) {
            return response()
                ->json([
                    'status'   => false,
                    'message'  => '存款金額不可低於 0',
                    'data'	   => [],
                ], '200');
        }
        
        $record = $user->accounts()
            ->create([
                'amount' => $request->amount,
                'balance' => $balance
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
