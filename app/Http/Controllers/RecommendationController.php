<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $recs = Recommendation::with('document')
            ->where('user_id', $userId)
            ->orderByDesc('score')
            ->get();

        return response()->json($recs);
    }
}
