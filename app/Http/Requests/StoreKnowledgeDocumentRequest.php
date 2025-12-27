<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKnowledgeDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'confidentiality' => 'required|in:PUBLIC,INTERNAL,RESTRICTED',
            'project_id' => 'nullable|integer|exists:projects,id',
            'workspace_id' => 'nullable|integer|exists:workspaces,id',
            'tag_ids' => 'array',
            'tag_ids.*' => 'integer|exists:tags,id',
        ];
    }
}
