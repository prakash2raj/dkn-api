<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKnowledgeDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'confidentiality' => 'sometimes|required|in:PUBLIC,INTERNAL,RESTRICTED',
            'status' => 'sometimes|required|in:DRAFT,PENDING_VALIDATION,VALIDATED,ARCHIVED',
            'project_id' => 'sometimes|nullable|integer|exists:projects,id',
            'workspace_id' => 'sometimes|nullable|integer|exists:workspaces,id',
            'tag_ids' => 'sometimes|array',
            'tag_ids.*' => 'integer|exists:tags,id',
        ];
    }
}
