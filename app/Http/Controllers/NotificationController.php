<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Daftar seluruh notifikasi milik user yang sedang login.
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca, lalu redirect ke halaman terkait.
     */
    public function markAsRead(Request $request, string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        $penyewaanId = $notification->data['penyewaan_id'] ?? null;

        if ($penyewaanId) {
            $routeName = Auth::user()->isAdmin()
                ? 'admin.penyewaan.show'
                : 'user.penyewaan.show';

            return redirect()->route($routeName, $penyewaanId);
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Tandai semua notifikasi milik user sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}