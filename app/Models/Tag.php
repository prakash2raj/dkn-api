<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag_name'];

    public function documents()
    {
        return $this->belongsToMany(KnowledgeDocument::class, 'knowledge_document_tag');
    }
}
