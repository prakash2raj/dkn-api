<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegulatoryConstraint extends Model
{
    protected $fillable = ['regulation_id', 'region', 'office_id'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
