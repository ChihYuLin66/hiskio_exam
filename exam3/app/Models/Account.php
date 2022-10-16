<?php

namespace App\Models;

use App\Observers\AccountObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'amount', 'balance'
    ];

    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted()
    {
        parent::boot();
        
        parent::observe(AccountObserver::class);
    }

    // 關聯使用者
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
