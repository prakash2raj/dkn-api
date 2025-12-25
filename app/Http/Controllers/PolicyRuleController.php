<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\KnowledgeDocument;
use App\Models\PolicyRule;
use Illuminate\Http\Request;

class PolicyRuleController extends Controller
{
    public function index($documentId, Request $request)
    {
        $doc = KnowledgeDocument::findOrFail($documentId);
        $this->authorizeDocumentAccess($doc, $request->user());

        $rules = $doc->policyRules;
        return response()->json($rules);
    }

    public function store($documentId, Request $request)
    {
        $doc = KnowledgeDocument::findOrFail($documentId);
        $this->authorizeDocumentAccess($doc, $request->user(), true);

        $data = $request->validate([
            'rule_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $rule = PolicyRule::create([
            'knowledge_document_id' => $doc->id,
            'rule_type' => $data['rule_type'],
            'description' => $data['description'] ?? null,
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'CREATE_POLICY_RULE',
            'action_type' => 'CREATE',
            'entity_type' => 'KnowledgeDocument',
            'entity_id' => $doc->id,
        ]);

        return response()->json($rule, 201);
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
