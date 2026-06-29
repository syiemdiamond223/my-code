<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Booking;

class AdminController extends Controller
{
    //Admin Dashboard
    public function dashboard()
    {
        //System Statistics
        $totalUsers = User::whereIn('role', ['student', 'tutor'])->count();
        $totalTutors = Tutor::where('status', 'approved')->count();
        $pendingTutors = Tutor::where('status', 'pending')->count();
        $totalBookings = Booking::count();

        $recentTutors = Tutor::where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();

        $recentBookings = Booking::latest()->take(5)->get();

        //Latest Activity
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

    //User Management
    public function users()
    {
        $users = User::where('role', '!=', 'admin')
            ->latest()
            ->get();

        return view('admin.users', compact('users'));
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

    //Tutor Admin Approval
    // LIST PAGE
    public function tutors()
    {
        $tutors = Tutor::with('user')
            ->latest()
            ->get();

        return view('admin.tutors', compact('tutors'));
    }

    // PROFILE VIEW PAGE
    public function showTutor(int $id)
    {
        $tutor = Tutor::with(['user', 'subjects'])
            ->findOrFail($id);

        return view('admin.show', compact('tutor'));
    }

    // APPROVE
    public function approveTutor(int $id)
    {
        $tutor = Tutor::findOrFail($id);
       // Update tutor status to approved and clear any rejection message
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
        // Update tutor status to rejected and save the rejection message
        $tutor->update([
            'status' => 'rejected',
            'rejection_message' => $request->rejection_message,
        ]);

        return back()->with('success', 'Tutor rejected successfully.');
    }

    //Bookings Management
    public function bookings(Request $request)
    {
        $bookings = Booking::with('student', 'tutor.user', 'subject');

        // Student Search
        if ($request->filled('student')) {

            $bookings->whereHas('student', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->student . '%');
            });

        }

        // Tutor Search
        if ($request->filled('tutor')) {

            $bookings->whereHas('tutor.user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->tutor . '%');
            });

        }

        // Booking Status
        if ($request->filled('status')) {

            $bookings->where('status', $request->status);

        }

        // Session Date
        if ($request->filled('date')) {

            $bookings->whereDate('session_date', $request->date);

        }

        $bookings = $bookings->latest()->get();

        return view('admin.bookings', compact('bookings'));
    }

    //Payments Management
   public function payments(Request $request)
    {
        $payments = Booking::with('student', 'tutor.user', 'subject')
            ->whereNotNull('payment_status');

        // Search Student Name
        if ($request->filled('student')) {

            $payments->whereHas('student', function ($query) use ($request) {

                $query->where(
                    'name',
                    'like',
                    '%' . $request->student . '%'
                );

            });

        }

        // Search Tutor Name
        if ($request->filled('tutor')) {

            $payments->whereHas('tutor.user', function ($query) use ($request) {

                $query->where(
                    'name',
                    'like',
                    '%' . $request->tutor . '%'
                );

            });

        }

        // Filter Payment Status
        if ($request->filled('status')) {

            $payments->where(
                'payment_status',
                $request->status
            );

        }

        // Filter Session Date
        if ($request->filled('date')) {

            $payments->whereDate(
                'session_date',
                $request->date
            );

        }

        $payments = $payments->latest()->get();

        // PAYMENT STATISTICS

        $totalRevenue = Booking::where('payment_status', 'paid')
            ->sum('total_price');

        $totalPaidTransactions = Booking::where('payment_status', 'paid')
            ->count();

        $pendingPayments = Booking::where('payment_status', 'pending')
            ->count();

        $totalRefunds = Booking::whereIn('refund_status', [
            'refunded',
            'partial_refund'
        ])->sum('refund_amount');

        return view('admin.payments', compact(
            'payments',
            'totalRevenue',
            'totalPaidTransactions',
            'pendingPayments',
            'totalRefunds'
        ));
    }
}