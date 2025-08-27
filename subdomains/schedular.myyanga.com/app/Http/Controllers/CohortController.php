<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CohortController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'instructor_id' => 'nullable|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cohort = new Cohort();
        $cohort->fill($request->all());
        $cohort->created_by = $request->user->id; // Assign the current user's ID to created_by

        // If an instructor ID is provided, assign it to the cohort
        if ($request->has('instructor_id')) {
            $cohort->instructor_id = $request->instructor_id;
        }
        
        $cohort->save();


        return response()->json(['message' => 'Cohort created successfully', 'cohort' => $cohort], 201);
    }

    public function update(Request $request, $id)
    {
        $cohort = Cohort::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'course_id' => 'exists:courses,id',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'instructor_id' => 'nullable|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update cohort attributes
        $cohort->fill($request->all());

        // If an instructor ID is provided, update it for the cohort
        if ($request->has('instructor_id')) {
            $cohort->instructor_id = $request->instructor_id;
        }

        $cohort->save();


        return response()->json(['message' => 'Cohort updated successfully', 'cohort' => $cohort]);
    }

    public function destroy($id)
    {
        try {
            $cohort = Cohort::findOrFail($id);
            $cohort->delete();
            return response()->json(['message' => 'Cohort deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cohort not found'], 404);
        }
    }

    public function index()
    {
        $cohorts = Cohort::with(['course.resources', 'instructor'])->get();
        return response()->json($cohorts);
    }

    public function show($id)
    {
        try {
            $cohort = Cohort::with(['course.resources', 'cohortLocation.location', 'instructor'])->findOrFail($id);
            return response()->json($cohort);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cohort not found'], 404);
        }
    }
}
