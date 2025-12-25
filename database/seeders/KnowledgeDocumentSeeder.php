<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeDocument;
use App\Models\User;
use App\Models\Project;
use App\Models\Workspace;
use App\Models\Tag;

class KnowledgeDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $consultant = User::where('role', 'CONSULTANT')->first();
        $champion   = User::where('role', 'CHAMPION')->first();

        $logisticsProject  = Project::where('domain', 'Logistics')->first();
        $energyProject     = Project::where('domain', 'Renewable Energy')->first();
        $manufactureProject = Project::where('domain', 'Smart Manufacturing')->first();
        $workspace = Workspace::first();
        $tagLogistics = Tag::where('tag_name', 'Logistics')->first();
        $tagEnergy = Tag::where('tag_name', 'Energy')->first();
        $tagGovernance = Tag::where('tag_name', 'Governance')->first();

        // ============================
        // Validated Knowledge Document
        // ============================
        KnowledgeDocument::create([
            'title' => 'Smart Logistics Optimisation Framework',
            'description' => 'A reusable framework for optimising supply chain operations using IoT and analytics.',
            'status' => 'VALIDATED',
            'confidentiality' => 'INTERNAL',
            'version' => 1,
            'created_by' => $consultant->id,
            'project_id' => $logisticsProject->id,
            'workspace_id' => $workspace?->id,
        ])->tags()->sync(array_filter([$tagLogistics?->id]));

        // ============================
        // Pending Validation Document
        // ============================
        KnowledgeDocument::create([
            'title' => 'Renewable Energy Grid Data Model',
            'description' => 'Data model and integration patterns for renewable energy smart grids.',
            'status' => 'PENDING_VALIDATION',
            'confidentiality' => 'RESTRICTED',
            'version' => 1,
            'created_by' => $consultant->id,
            'project_id' => $energyProject->id,
            'workspace_id' => $workspace?->id,
        ])->tags()->sync(array_filter([$tagEnergy?->id, $tagGovernance?->id]));

        // ============================
        // Archived Knowledge Document
        // ============================
        KnowledgeDocument::create([
            'title' => 'Legacy Manufacturing Integration Guide',
            'description' => 'Older integration guide for factory automation systems.',
            'status' => 'ARCHIVED',
            'confidentiality' => 'INTERNAL',
            'version' => 2,
            'created_by' => $champion->id,
            'project_id' => $manufactureProject->id,
            'workspace_id' => $workspace?->id,
        ])->tags()->sync(array_filter([$tagGovernance?->id]));
    }
}
