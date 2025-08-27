<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function createCourse(Request $request)
    {
        $user = $request->user;

        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:courses,title',
            'description' => 'required|string',
            'duration' => 'required|int',
            'price' => 'required|numeric',
            'featured_image' => 'required|string', // Validate featured_image if provided
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle featured_image upload if provided
        if ($request->hasFile('featured_image')) {
            $featured_image = $request->file('featured_image');
            $filename = time() . '_' . $featured_image->getClientOriginalName(); // Generate unique filename
            $path = $featured_image->storeAs('featured_images', $filename); // Store featured_image with new filename
        }

        // Create new course
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'featured_image' =>$request->featured_image, // Store featured_image path if provided
            'created_by' => $user->id, // Assign current authenticated user as creator
        ]);

        // Return success response
        return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
    }

    public function updateCourse(Request $request, $id)
    {
        // Find the course by its ID
        $course = Course::find($id);

        // Check if the course exists
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        // Validate request data
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            // Add other validation rules as needed
        ]);

        // Handle featured_image upload
        if ($request->hasFile('featured_image')) {
            $featured_image = $request->file('featured_image');
            $filename = time() . '_' . $featured_image->getClientOriginalName(); // Generate unique filename
            $path = $featured_image->storeAs('featured_images', $filename); // Store featured_image with new filename

            // Update the featured_image field in the course
            $course->featured_image = $filename;
        }

        // Update the course
        $course->update($request->all());

        // Return success response
        return response()->json(['message' => 'Course updated successfully'], 200);
    }

    public function index()
    {
        $courses = Course::with(['creator', 'resources'])->get();
        return response()->json($courses);
    }


    public function show($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }
        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
