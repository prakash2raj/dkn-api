<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $fillable = ['name', 'visibility'];

    public function documents()
    {
        return $this->hasMany(KnowledgeDocument::class);
    }
}
