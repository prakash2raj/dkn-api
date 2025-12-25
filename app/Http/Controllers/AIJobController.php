<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\AIJob;
use App\Models\KnowledgeDocument;
use Illuminate\Http\Request;

class AIJobController extends Controller
{
    public function index($documentId, Request $request)
    {
        $doc = KnowledgeDocument::findOrFail($documentId);
        $this->authorizeDocumentAccess($doc, $request->user());

        return response()->json($doc->aiJobs);
    }

    public function store($documentId, Request $request)
    {
        $doc = KnowledgeDocument::findOrFail($documentId);
        $this->authorizeDocumentAccess($doc, $request->user(), true);

        $data = $request->validate([
            'job_type' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $job = AIJob::create([
            'knowledge_document_id' => $doc->id,
            'job_type' => $data['job_type'],
            'status' => $data['status'] ?? 'PENDING',
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'CREATE_AI_JOB',
            'action_type' => 'CREATE',
            'entity_type' => 'KnowledgeDocument',
            'entity_id' => $doc->id,
        ]);

        return response()->json($job, 201);
    }

    private function authorizeDocumentAccess(KnowledgeDocument $doc, $user, bool $requireElevated = false): void
    {
        $canViewUnvalidated = in_array($user->role, ['CHAMPION', 'GOVERNANCE', 'ADMIN'])
            || $doc->created_by === $user->id;

        if ($doc->status !== 'VALIDATED' && !$canViewUnvalidated) {
            abort(403, 'Access denied');
        }

        if ($requireElevated && !in_array($user->role, ['CHAMPION', 'GOVERNANCE', 'ADMIN'])) {
            abort(403, 'Access denied');
        }
    }
}
