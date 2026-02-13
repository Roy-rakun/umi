<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'affiliate_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'affiliate_id', 'affiliate_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'affiliate_id', 'affiliate_id');
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'affiliate_id', 'affiliate_id');
    }

    public function links()
    {
        return $this->hasMany(AffiliateLink::class, 'affiliate_id', 'affiliate_id');
    }
}
