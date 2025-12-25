<?php

namespace App\Http\Controllers;

use App\Models\ExpertiseProfile;
use Illuminate\Http\Request;

class ExpertiseProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = ExpertiseProfile::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json($profile);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'skills' => 'nullable|string',
            'experience_level' => 'nullable|string',
        ]);

        $profile = ExpertiseProfile::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $profile->update($data);

        return response()->json($profile);
    }
}
