<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'commission_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id', 'affiliate_id');
    }
}
