<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeDetail extends Model
{
    //
    protected $fillable = [
        'symbol',
        'buy_price',
        'target_price',
        'stop_loss',
        'deadline',
        'status',
        'sell_price',

    ];
    
}
