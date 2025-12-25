<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name')->unique();
            $table->timestamps();
        });

        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('office_id')->unique();
            $table->string('region');
            $table->string('network_status')->nullable();
            $table->timestamps();
        });

        Schema::create('regulatory_constraints', function (Blueprint $table) {
            $table->id();
            $table->string('regulation_id')->unique();
            $table->string('region');
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('role')->constrained('roles')->nullOnDelete();
            $table->foreignId('office_id')->nullable()->after('region')->constrained('offices')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
            $table->dropConstrainedForeignId('office_id');
        });

        Schema::dropIfExists('regulatory_constraints');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('roles');
    }
};
