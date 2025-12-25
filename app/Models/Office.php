<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = ['office_id', 'region', 'network_status'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function regulatoryConstraints()
    {
        return $this->hasMany(RegulatoryConstraint::class);
    }
}
