<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'amount', 'balance', 'description'
    ];

    // 關聯使用者
    public function user() 
    {
        return $this->belongsTo(User::class);
    }


}
