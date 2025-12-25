<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardEntry extends Model
{
    protected $fillable = ['user_id', 'period', 'rank'];

    protected $casts = [
        'period' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
