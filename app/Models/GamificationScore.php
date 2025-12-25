<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamificationScore extends Model
{
    protected $fillable = ['user_id', 'points', 'badges'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
