<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKnowledgeDocumentRequest;
use App\Models\AuditLog;
use App\Models\KnowledgeDocument;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class KnowledgeDocumentController extends Controller
{
    public function index()
    {
        // For simplicity: return only VALIDATED documents for general view
        $docs = KnowledgeDocument::with('creator', 'project', 'workspace', 'tags')
            ->where('status', 'VALIDATED')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($docs);
    }

    public function show($id, Request $request)
    {
        $user = $request->user();

        $doc = KnowledgeDocument::with(
            'creator',
            'project',
            'workspace',
            'tags',
            'policyRules',
            'aiJobs'
        )->findOrFail($id);

        // Access rules: validated docs are public to authenticated users.
        // Otherwise allow owners, champions, governance, and admins to see details.
        $canViewUnvalidated = in_array($user->role, ['CHAMPION', 'GOVERNANCE', 'ADMIN'])
            || $doc->created_by === $user->id;

        if ($doc->status !== 'VALIDATED' && !$canViewUnvalidated) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        return response()->json($doc);
    }

    public function mine(Request $request)
    {
        $userId = $request->user()->id;

        $docs = KnowledgeDocument::with('creator', 'project', 'workspace', 'tags')
            ->where('created_by', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($docs);
    }

    public function pending()
    {
        $docs = KnowledgeDocument::with('creator', 'project', 'workspace', 'tags')
            ->where('status', 'PENDING_VALIDATION')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($docs);
    }

    public function store(StoreKnowledgeDocumentRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        $this->enforceRegulatoryConstraints($user, $data['confidentiality']);

        $doc = KnowledgeDocument::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'PENDING_VALIDATION',
            'confidentiality' => $data['confidentiality'],
            'version' => 1,
            'created_by' => $user->id,
            'project_id' => $data['project_id'] ?? null,
            'workspace_id' => $data['workspace_id'] ?? null
        ]);

        if (!empty($data['tag_ids'])) {
            $doc->tags()->sync($data['tag_ids']);
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'UPLOAD_DOCUMENT',
            'action_type' => 'CREATE',
            'entity_type' => 'KnowledgeDocument',
            'entity_id' => $doc->id,
        ]);

        return response()->json($doc, 201);
    }

    private function enforceRegulatoryConstraints($user, string $confidentiality): void
    {
        $user->loadMissing('office.regulatoryConstraints');

        $office = $user->office;
        if (!$office) {
            abort(403, 'Office assignment required to upload documents.');
        }

        $constraint = $office->regulatoryConstraints->first();
        if (!$constraint) {
            abort(403, 'No regulatory constraints configured for your office.');
        }

        $isPrivileged = in_array($user->role, ['CHAMPION', 'GOVERNANCE', 'ADMIN']);
        if (in_array($confidentiality, ['INTERNAL', 'RESTRICTED'])
            && $user->region
            && $constraint->region !== $user->region
            && !$isPrivileged) {
            abort(403, 'Upload blocked due to data residency requirements for your region.');
        }
    }

    public function validateDoc($id, Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'CHAMPION' && $user->role !== 'GOVERNANCE') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $doc = KnowledgeDocument::findOrFail($id);
        $doc->status = 'VALIDATED';
        $doc->save();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'VALIDATE_DOCUMENT',
            'action_type' => 'UPDATE',
            'entity_type' => 'KnowledgeDocument',
            'entity_id' => $doc->id,
        ]);

        // simple "AI" recommendation entry
        Recommendation::create([
            'user_id' => $user->id, // in real life, for many users
            'knowledge_document_id' => $doc->id,
            'type' => 'CONTENT',
            'score' => 0.9,
        ]);

        return response()->json(['message' => 'Document validated']);
    }
}
