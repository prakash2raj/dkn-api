<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name','domain','status'];

    public function documents() {
        return $this->hasMany(KnowledgeDocument::class);
    }
}
