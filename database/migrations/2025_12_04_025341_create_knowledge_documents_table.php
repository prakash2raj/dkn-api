<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['DRAFT', 'PENDING_VALIDATION', 'VALIDATED', 'ARCHIVED'])
                ->default('PENDING_VALIDATION');
            $table->enum('confidentiality', ['PUBLIC', 'INTERNAL', 'RESTRICTED'])
                ->default('INTERNAL');
            $table->integer('version')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_documents');
    }
};
