<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $instructors = Instructor::all();
        return response()->json($instructors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'photo' => 'required|string',
            'linkedin_url' => 'required|string',
            'bio' => 'required|string',
        ]);

        $instructor = Instructor::create($request->all());

        return response()->json($instructor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $instructor = Instructor::findOrFail($id);
        return response()->json($instructor);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'photo' => 'required|string',
            'linkedin_url' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->all());

        return response()->json($instructor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();

        return response()->json(['message' => 'Instructor deleted successfully']);
    }
}
