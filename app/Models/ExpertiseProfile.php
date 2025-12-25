<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertiseProfile extends Model
{
    protected $fillable = ['user_id', 'skills', 'experience_level'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
