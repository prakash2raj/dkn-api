<?php

namespace App\Http\Controllers;

use App\Models\Office;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::with('regulatoryConstraints')->orderBy('office_id')->get();
        return response()->json($offices);
    }
}
