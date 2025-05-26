<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notif->is_read = true;
        $notif->save();

        return redirect()->back();
    }
}
