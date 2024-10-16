<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spinBetlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_no',
        'number',
        'amount',
        'status',
    ];
    
    public function spinBets()
{
    return $this->hasMany(SpinBet::class, 'period_no', 'period_no');
}


}
