<?php

namespace App\Http\Controllers;

use App\Models\Workspace;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = Workspace::orderBy('name')->get();
        return response()->json($workspaces);
    }
}
