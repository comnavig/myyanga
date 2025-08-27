<?php

namespace App\Http\Controllers;

use App\Models\CohortLocation;
use Illuminate\Http\Request;

class CohortLocationController extends Controller
{
    public function index()
    {
        $cohortLocations = CohortLocation::all();
        return response()->json($cohortLocations);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cohort_id' => 'required|exists:cohorts,id',
            'location_id' => 'nullable|exists:locations,id',
            'zoom_url' => 'nullable|url',
            'start_date' => 'nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date',
        ]);

        $cohortLocation = CohortLocation::create($validatedData);

        return response()->json($cohortLocation, 201);
    }

    public function show($id)
    {
        $cohortLocation = CohortLocation::findOrFail($id);
        return response()->json($cohortLocation);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cohort_id' => 'exists:cohorts,id',
            'location_id' => 'exists:locations,id',
            'zoom_url' => 'url',
            'start_date' => 'nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date',
        ]);

        $cohortLocation = CohortLocation::findOrFail($id);
        $cohortLocation->update($validatedData);

        return response()->json($cohortLocation, 200);
    }

    public function destroy($id)
    {
        $cohortLocation = CohortLocation::findOrFail($id);
        $cohortLocation->delete();

        return response()->json(['message' => 'Cohort location deleted successfully']);
    }
}
