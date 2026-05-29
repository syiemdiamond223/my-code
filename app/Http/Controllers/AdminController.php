<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Booking;

class AdminController extends Controller
{
    // =========================
    // DASHBOARD
    // =========================
    public function dashboard()
    {
        $totalUsers = User::whereIn('role', ['student', 'tutor'])->count();
        $totalTutors = Tutor::where('status', 'approved')->count();
        $pendingTutors = Tutor::where('status', 'pending')->count();
        $totalBookings = Booking::count();

        $recentTutors = Tutor::where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();

        $recentBookings = Booking::latest()->take(5)->get();

        $todayUsers = User::whereIn('role', ['student', 'tutor'])
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        $todayBookings = Booking::whereDate('session_date', today())
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTutors',
            'pendingTutors',
            'totalBookings',
            'recentTutors',
            'recentBookings',
            'todayUsers',
            'todayBookings'
        ));
    }

    // =========================
    // USERS
    // =========================
    public function users()
    {
        $users = User::where('role', '!=', 'admin')
            ->latest()
            ->get();

        return view('admin.users', compact('users'));
    }

    public function blockUser(int $id)
    {
        $user = User::findOrFail($id);

        $user->update(['status' => 'blocked']);

        return back()->with('success', 'User blocked successfully.');
    }

    public function unblockUser(int $id)
    {
        $user = User::findOrFail($id);

        $user->update(['status' => 'active']);

        return back()->with('success', 'User unblocked successfully.');
    }

    public function toggleUserStatus(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back();
        }

        $user->status = $user->status === 'blocked' ? 'active' : 'blocked';
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    // =========================
    // TUTORS (ADMIN APPROVAL FLOW)
    // =========================

    // LIST PAGE
    public function tutors()
    {
        $tutors = Tutor::with('user')
            ->latest()
            ->get();

        return view('admin.tutors', compact('tutors'));
    }

    // PROFILE VIEW PAGE
    public function showTutor($id)
    {
        $tutor = Tutor::with(['user', 'subjects'])
            ->findOrFail($id);

        return view('admin.show', compact('tutor'));
    }

    // APPROVE
    public function approveTutor(int $id)
    {
        $tutor = Tutor::findOrFail($id);

        $tutor->update([
            'status' => 'approved',
            'rejection_message' => null
        ]);

        return back()->with('success', 'Tutor approved successfully.');
    }

    // REJECT
    public function rejectTutor(Request $request, int $id)
    {
        $request->validate([
            'rejection_message' => 'required|string|max:500',
        ]);

        $tutor = Tutor::findOrFail($id);

        $tutor->update([
            'status' => 'rejected',
            'rejection_message' => $request->rejection_message,
        ]);

        return back()->with('success', 'Tutor rejected successfully.');
    }

    // =========================
    // BOOKINGS
    // =========================
    public function bookings()
    {
        $bookings = Booking::with('student', 'tutor.user', 'subject')
            ->latest()
            ->get();

        return view('admin.bookings', compact('bookings'));
    }

    // =========================
    // PAYMENTS
    // =========================
    public function payments()
    {
        $payments = Booking::with('student', 'tutor.user', 'subject')
            ->whereNotNull('payment_status')
            ->latest()
            ->get();

        return view('admin.payments', compact('payments'));
    }
}