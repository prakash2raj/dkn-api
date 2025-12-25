<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->boolean('active_only', true)) {
            $query->where('status', 'ACTIVE');
        }

        $projects = $query->orderBy('name')->get();

        return response()->json($projects);
    }
}
