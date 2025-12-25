<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    protected $fillable = [
        'title','description','status','confidentiality',
        'version','created_by','project_id','workspace_id'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function workspace() {
        return $this->belongsTo(Workspace::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'knowledge_document_tag');
    }

    public function policyRules() {
        return $this->hasMany(PolicyRule::class);
    }

    public function aiJobs() {
        return $this->hasMany(AIJob::class);
    }
}
