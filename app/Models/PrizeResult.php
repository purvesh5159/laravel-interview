<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrizeResult extends Model
{
    use HasFactory;
    protected $fillable = ['prize_id', 'awarded_at'];
    
    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
