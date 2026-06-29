<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;

class StudentController extends Controller
{
    // SEARCH TUTORS
    public function search(Request $request)
    {
        $query = $request->input('search');

        $tutors = Tutor::with([
            'user',
            'subjects',
            'availabilities' => function ($q) {
                $q->where('status', 'available')
                  ->whereNotIn('id', function ($sub) {
                        $sub->select('availability_id')
                            ->from('bookings');
                  });
            }
        ])
        ->where('status', 'approved')
        ->whereHas('user', function ($q) {
            $q->where('status', 'active');
        })
        ->when($query, function ($q) use ($query) {
            $q->whereHas('subjects', function ($sub) use ($query) {
                $sub->where('name', 'LIKE', "%{$query}%");
            });
        })
        ->latest()
        ->get();

        return view('student.search', compact('tutors', 'query'));
    }

    // VIEW TUTOR PROFILE
    public function showTutor($id)
    {
        $tutor = Tutor::with([
            'user',
            'subjects',
            'availabilities'
        ])
        ->where('status', 'approved')
        ->whereHas('user', function ($q) {
            $q->where('status', 'active');
        })
        ->findOrFail($id);

        return view('student.tutor-profile', compact('tutor'));
    }
}