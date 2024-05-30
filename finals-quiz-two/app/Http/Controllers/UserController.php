<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
        public function userIndex() {
            // Retrieve all users from the database
            $users = User::all();
            
            // Return the list of users as a response
            return response()->json([
                'users' => $users,
                'message' => 'Users fetched successfully',
                'code' => 200], 200);
        }
    

    public function showUser($id) {
         // Validate ID
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['message' => 'Invalid user ID'], 400);
        }

        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the user's email and name
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin
        ], 200);
    }

    public function storeUser(Request $request) {
        // Field validation
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'is_admin' => 'boolean'
        ]);

        // Determine if the user is an admin
        $isAdmin = $request->input('is_admin', false);
        
        // user data creation
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'is_admin' => $isAdmin,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);

        // token creation
        $token = $user->createToken('myapptoken')->plainTextToken;

        // JSON Response
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function editUser(Request $request, $id) {
       // Validate ID
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['message' => 'Invalid user ID'], 400);
        }

        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Field validation
        $fields = $request->validate([
            'name' => 'string',
            'email' => 'string|unique:users,email,'.$id,
            'password' => 'string|confirmed',
            'is_admin' => 'boolean'
        ]);

        // Update the user fields
        $user->fill($fields);

        // Save the updated user
        $user->save();

        // Return success message
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function deleteUser($id) {
        // Validate ID
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['message' => 'Invalid user ID'], 400);
        }

        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        // Return success message
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'is_admin' => 'required|boolean',
        ]);

        $user->update([
            'is_admin' => $request->is_admin,
        ]);

        return response()->json(['message' => 'User role updated successfully']);
    }
}
