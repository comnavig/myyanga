<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        // Retrieve list of users from the database
        $users = User::all();

        // Return the list of users as a JSON response
        return response()->json($users);
    }

    public function createAccount(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'user_role' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create new user account
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'user_role' => $request->user_role,
        ]);

        // Return success response
        return response()->json(['message' => 'User account created successfully'], 201);
    }


    public function editUser(Request $request, $userId)
    {
        // Find the user by ID
        $user = User::findOrFail($userId);

        // Validate the request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional: validate photo
        ]);

        // Update user profile data
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $photoPath;
            $user->save();
        }

        // Return success response
        return response()->json(['message' => 'User profile updated successfully']);
    }

    public function getUserById($id)
    {
        // Find the user by their ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            // Return 404 Not Found response if user does not exist
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return the user details as a JSON response
        return response()->json($user);
    }
}
