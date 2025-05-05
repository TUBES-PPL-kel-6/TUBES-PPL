<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // Show the complaint submission form
    public function showForm()
    {
        return view('complaint');  // Adjust the view name if necessary
    }

    // Store the complaint after the form is submitted
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:5120', // Optional images, max 5MB each
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Create the complaint
        $complaint = new Complaint([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'response' => null,
        ]);
        
        // Associate with user if logged in
        if ($user) {
            $complaint->user_id = $user->id;
        }
        
        $complaint->save();

        // Handle image uploads if present
        if ($request->hasFile('images')) {
            // Note: You would need to create another method/model to store images
            // This is just a placeholder for potential image handling
        }

        // Redirect back to the form with a success message
        return redirect()->route('complaint.create')
            ->with('success', 'Keluhan Anda telah berhasil dikirim.');
    }
}
