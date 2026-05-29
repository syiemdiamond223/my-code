<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class TutorProfileController extends Controller
{
    // FORM
    public function form()
    {
        $tutor = Tutor::where('user_id', Auth::id())->first();
        $subjects = Subject::all();

        $qualifications = [
            'B.Sc Mathematics','B.Sc Physics','B.Sc Chemistry','B.Sc Computer Science',
            'BCA','B.Com','B.A English','B.A Economics','B.Ed',
            'M.Sc Mathematics','M.Sc Physics','M.Sc Chemistry','M.Sc Computer Science',
            'MCA','M.Com','M.A English','M.A Economics','M.Ed','Other'
        ];

        $institutions = [
            'North Eastern Hill University (NEHU)',
            'St. Edmund’s College','St. Anthony’s College','St. Mary’s College',
            'Shillong College','Lady Keane College','Synod College',
            'Gauhati University','Assam Don Bosco University','Royal Global University',
            'Other'
        ];

        return view('tutor.profile.form', compact(
            'tutor','subjects','qualifications','institutions'
        ));
    }

    // STORE (FIRST TIME)
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $qualification = $request->qualification === 'Other'
            ? $request->other_qualification
            : $request->qualification;

        $institution = $request->institution === 'Other'
            ? $request->other_institution
            : $request->institution;

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $tutor = Tutor::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'phone' => $request->phone,
                'price_per_hour' => $request->price,
                'mode' => $request->mode,
                'bio' => $request->bio,
                'qualification' => $qualification,
                'experience' => $request->experience,
                'institution' => $institution,
                'status' => 'pending',
                'rejection_message' => null,
            ]
        );

        $tutor->subjects()->sync($request->subjects ?? []);

        return redirect()->route('tutor.dashboard')
            ->with('success', 'Profile submitted successfully and sent for admin approval.');
    }

    // UPDATE
    public function update(Request $request)
    {
        $this->validateRequest($request);

        $qualification = $request->qualification === 'Other'
            ? $request->other_qualification
            : $request->qualification;

        $institution = $request->institution === 'Other'
            ? $request->other_institution
            : $request->institution;

        $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();

        $tutor->update([
            'phone' => $request->phone,
            'price_per_hour' => $request->price,
            'mode' => $request->mode,
            'bio' => $request->bio,
            'qualification' => $qualification,
            'experience' => $request->experience,
            'institution' => $institution,
            'status' => 'pending',
            'rejection_message' => null,
        ]);

        $tutor->subjects()->sync($request->subjects ?? []);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('tutor.dashboard')
            ->with('success', 'Profile updated successfully and sent for admin review.');
    }

    // VALIDATION (REUSED)
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'required|digits:10',
            'price' => 'required|numeric|min:1',
            'mode' => 'required|in:online,offline,both',
            'bio' => 'required|string|min:20|max:500',
            'qualification' => 'required|string|max:255',
            'other_qualification' => 'required_if:qualification,Other|nullable|string|max:255',
            'experience' => 'required|integer|min:1|max:5',
            'institution' => 'required|string|max:255',
            'other_institution' => 'required_if:institution,Other|nullable|string|max:255',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
        ]);
    }
}