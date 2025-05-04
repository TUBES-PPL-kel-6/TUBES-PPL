<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscussionComment;
use Illuminate\Support\Facades\Auth;

class DiscussionCommentController extends Controller
{
    public function store(Request $request, $discussionId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        DiscussionComment::create([
            'discussion_id' => $discussionId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
} 