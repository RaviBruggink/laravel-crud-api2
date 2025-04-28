<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;

class MissionController extends Controller
{
    // GET /api/missions
    public function index()
    {
        return response()->json(Mission::all());
    }

    // POST /api/missions
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'launch_date' => 'required|date',
            'destination' => 'required|string|max:255',
            'crew_size' => 'required|integer|min:1',
        ]);

        $mission = Mission::create($validated);

        return response()->json($mission, 201);
    }

    // GET /api/missions/{id}
    public function show(Mission $mission)
    {
        return response()->json($mission);
    }

    // PUT/PATCH /api/missions/{id}
    public function update(Request $request, Mission $mission)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'launch_date' => 'sometimes|required|date',
            'destination' => 'sometimes|required|string|max:255',
            'crew_size' => 'sometimes|required|integer|min:1',
        ]);

        $mission->update($validated);

        return response()->json($mission);
    }

    // DELETE /api/missions/{id}
    public function destroy(Mission $mission)
    {
        $mission->delete();

        return response()->json(null, 204);
    }
}
