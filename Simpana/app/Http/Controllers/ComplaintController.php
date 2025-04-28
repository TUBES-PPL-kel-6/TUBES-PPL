<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

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
        ]);

        // Store the complaint in the database (skip user_id for now)
        Complaint::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',  // Default status is 'pending'
            'response' => null,     // No response initially
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('complaint.create')
            ->with('success', 'Keluhan Anda telah berhasil dikirim. Admin akan segera menindaklanjuti.');
    }
}
