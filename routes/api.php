<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AIJobController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpertiseProfileController;
use App\Http\Controllers\GamificationScoreController;
use App\Http\Controllers\KnowledgeDocumentController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PolicyRuleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RegulatoryConstraintController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    // ============================
    // ACCESS FOR ALL AUTH USERS
    // ============================
    Route::get('/documents', [KnowledgeDocumentController::class, 'index']);
    Route::get('/documents/mine', [KnowledgeDocumentController::class, 'mine']);
    Route::post('/documents', [KnowledgeDocumentController::class, 'store']);
    Route::put('/documents/{id}', [KnowledgeDocumentController::class, 'update']);
    Route::delete('/documents/{id}', [KnowledgeDocumentController::class, 'destroy']);
    Route::get('/recommendations', [RecommendationController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/workspaces', [WorkspaceController::class, 'index']);
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store'])->middleware(RoleMiddleware::class . ':ADMIN');
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/gamification', [GamificationScoreController::class, 'show']);
    Route::get('/expertise-profile', [ExpertiseProfileController::class, 'show']);
    Route::put('/expertise-profile', [ExpertiseProfileController::class, 'update']);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/offices', [OfficeController::class, 'index']);
    Route::get('/regulatory-constraints', [RegulatoryConstraintController::class, 'index']);

    // ============================
    // CHAMPION + GOVERNANCE
    // ============================
    Route::get(
        '/documents/pending',
        [KnowledgeDocumentController::class, 'pending']
    )->middleware(RoleMiddleware::class . ':CHAMPION,GOVERNANCE');

    Route::put(
        '/documents/{id}/validate',
        [KnowledgeDocumentController::class, 'validateDoc']
    )->middleware(RoleMiddleware::class . ':CHAMPION,GOVERNANCE');

    Route::get(
        '/documents/{id}/policy-rules',
        [PolicyRuleController::class, 'index']
    );
    Route::post(
        '/documents/{id}/policy-rules',
        [PolicyRuleController::class, 'store']
    )->middleware(RoleMiddleware::class . ':CHAMPION,GOVERNANCE,ADMIN');

    Route::get(
        '/documents/{id}/ai-jobs',
        [AIJobController::class, 'index']
    );
    Route::post(
        '/documents/{id}/ai-jobs',
        [AIJobController::class, 'store']
    )->middleware(RoleMiddleware::class . ':CHAMPION,GOVERNANCE,ADMIN');

    // ============================
    // DOCUMENT DETAILS (catch-all after specific routes)
    // ============================
    Route::get('/documents/{id}', [KnowledgeDocumentController::class, 'show']);

    // ============================
    // GOVERNANCE ONLY
    // ============================
    Route::get(
        '/audit-logs',
        [AuditController::class, 'index']
    )->middleware(RoleMiddleware::class . ':GOVERNANCE');

    // ============================
    // ADMIN ONLY
    // ============================
    Route::get(
        '/admin/users',
        fn () => \App\Models\User::all()
    )->middleware(RoleMiddleware::class . ':ADMIN');

});
