<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prize extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = ['title', 'probability', 'awarded_count'];

    public static function nextPrize()
    {
        $prizes = self::all();
        $total = 100;
        $random = mt_rand(1, 10000) / 100;
        $currentSum = 0;
        foreach ($prizes as $prize) {
            $currentSum += $prize->probability;
            if ($random <= $currentSum) {
                $prize->awarded_count++;
                $prize->save();
                
                PrizeResult::create([
                    'prize_id' => $prize->id,
                    'awarded_at' => now()
                ]);
                
                return $prize;
            }
        }
        
        return $prizes->first();
    }

    public function getActualProbabilityAttribute()
    {
        $totalAwarded =  Prize::sum('awarded_count');
        if ($totalAwarded === 0) return 0;
        
        return ($this->awarded_count / $totalAwarded) * 100;
    }
}
