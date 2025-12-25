<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyRule extends Model
{
    protected $fillable = ['knowledge_document_id', 'rule_type', 'description'];

    public function document()
    {
        return $this->belongsTo(KnowledgeDocument::class, 'knowledge_document_id');
    }
}
