<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'payout_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $guarded = [];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id', 'affiliate_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'payout_id', 'payout_id');
    }
}
