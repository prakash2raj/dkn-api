<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAIJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_type' => 'required|string',
            'status' => 'nullable|string|in:PENDING,IN_PROGRESS,COMPLETED,FAILED',
        ];
    }
}
