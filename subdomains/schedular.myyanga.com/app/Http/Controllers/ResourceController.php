<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    //


    public function index()
    {
        $resources = Resource::with('course')->get();
        return response()->json($resources);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
            'file_path' => 'required',
        ]);

        $resource = Resource::create($request->all());

        return response()->json(['message' => 'Resource created successfully', 'resource' => $resource], 201);
    }

    public function show(Resource $resource)
    {
        $resource->load('course');
        return response()->json($resource);
    }

    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'course_id' => 'exists:courses,id',
            'title' => 'required',
            'file_path' => 'required',
        ]);

        $resource->update($request->all());

        return response()->json(['message' => 'Resource updated successfully', 'resource' => $resource]);
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(['message' => 'Resource deleted successfully']);
    }
}
