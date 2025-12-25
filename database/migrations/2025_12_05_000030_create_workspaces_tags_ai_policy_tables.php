<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('visibility')->default('PRIVATE');
            $table->timestamps();
        });

        Schema::table('knowledge_documents', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('project_id')->constrained('workspaces')->nullOnDelete();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag_name')->unique();
            $table->timestamps();
        });

        Schema::create('knowledge_document_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledge_document_id')->constrained('knowledge_documents')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['knowledge_document_id', 'tag_id']);
        });

        Schema::create('policy_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledge_document_id')->constrained('knowledge_documents')->cascadeOnDelete();
            $table->string('rule_type');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledge_document_id')->constrained('knowledge_documents')->cascadeOnDelete();
            $table->string('job_type');
            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_jobs');
        Schema::dropIfExists('policy_rules');
        Schema::dropIfExists('knowledge_document_tag');
        Schema::dropIfExists('tags');

        Schema::table('knowledge_documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('workspace_id');
        });

        Schema::dropIfExists('workspaces');
    }
};
