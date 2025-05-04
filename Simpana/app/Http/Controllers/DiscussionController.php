<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::with('user')->latest()->get();
        return view('discussion', compact('discussions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Discussion::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('discussion.index')->with('success', 'Diskusi berhasil dibuat!');
    }

    public function edit(Discussion $discussion)
    {
        if ($discussion->user_id != Auth::id()) abort(403);
        return view('discussion_edit', compact('discussion'));
    }

    public function update(Request $request, Discussion $discussion)
    {
        if ($discussion->user_id != Auth::id()) abort(403);
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $discussion->update($request->only('title', 'body'));
        return redirect()->route('discussion.index')->with('success', 'Diskusi berhasil diupdate!');
    }

    public function destroy(Discussion $discussion)
    {
        if ($discussion->user_id != Auth::id()) abort(403);
        $discussion->delete();
        return redirect()->route('discussion.index')->with('success', 'Diskusi berhasil dihapus!');
    }
} 