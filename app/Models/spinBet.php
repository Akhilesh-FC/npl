<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class spinBet extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_no',
        'user_id',
        'bet',
        'win_number',
        'status',
        'game_id',
        'amount',
        'created_at',
        'updated_at',
    ];
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    
    public function user()
{
    return $this->belongsTo(User::class);
}

}
