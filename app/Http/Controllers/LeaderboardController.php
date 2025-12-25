<?php

namespace App\Http\Controllers;

use App\Models\LeaderboardEntry;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period');

        $query = LeaderboardEntry::with('user')->orderBy('rank');

        if ($period) {
            $query->where('period', $period);
        } else {
            $latest = LeaderboardEntry::max('period');
            if ($latest) {
                $query->where('period', $latest);
            }
        }

        $entries = $query->get();

        return response()->json($entries);
    }
}
