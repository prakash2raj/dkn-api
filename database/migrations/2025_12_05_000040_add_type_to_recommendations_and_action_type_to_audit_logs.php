<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            $table->string('type')->default('CONTENT')->after('knowledge_document_id');
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('action_type')->nullable()->after('action');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn('action_type');
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
