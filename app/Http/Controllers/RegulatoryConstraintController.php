<?php

namespace App\Http\Controllers;

use App\Models\RegulatoryConstraint;

class RegulatoryConstraintController extends Controller
{
    public function index()
    {
        $constraints = RegulatoryConstraint::with('office')->orderBy('regulation_id')->get();
        return response()->json($constraints);
    }
}
