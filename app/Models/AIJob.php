<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AIJob extends Model
{
    protected $table = 'ai_jobs';

    protected $fillable = ['knowledge_document_id', 'job_type', 'status'];

    public function document()
    {
        return $this->belongsTo(KnowledgeDocument::class, 'knowledge_document_id');
    }
}
