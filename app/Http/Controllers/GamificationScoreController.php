<?php

namespace App\Http\Controllers;

use App\Models\GamificationScore;
use Illuminate\Http\Request;

class GamificationScoreController extends Controller
{
    public function show(Request $request)
    {
        $score = GamificationScore::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json($score);
    }
}
