<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialClass;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;

class TrialClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation if necessary
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            // Other validation rules
        ]);
        TrialClass::create([
            'user_id' => auth()->id(),
            'course_id' => $request->course_id,
            'trial_start' => now(),
            'trial_end' => now()->addDays(7), // Example: 7-day trial
        ]);

        return redirect()->back()->with('success', 'Trial class started successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registerTrialClass(Request $request, User $user, Course $course)
    {
        // Check if the user is already registered for a trial of this course
        if ($user->trialClasses()->where('course_id', $course->id)->exists()) {
            return response()->json(['message' => 'User is already registered for a trial class.'], 400);
        }
        $trialStart = Carbon::now();
        $trialEnd = Carbon::now()->addDays(7);
        $trialClass = TrialClass::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',  // Initial status
            'trial_start' => $trialStart,
            'trial_end' => $trialEnd,
        ]);
        return response()->json([
            'message' => 'Trial class successfully registered!',
            'trial_class' => $trialClass,
        ], 201);
    }

    public function checkTrialClassStatus(User $user, Course $course)
    {
        $trialClass = $user->trialClasses()->where('course_id', $course->id)->first();

        if ($trialClass) {
            if (Carbon::now()->greaterThan($trialClass->trial_end)) {
                $trialClass->update(['status' => 'completed']);
                return response()->json(['message' => 'Trial class expired.'], 200);
            } else {
                return response()->json([
                    'message' => 'Trial class is still active.',
                    'trial_class' => $trialClass
                ], 200);
            }
        }

        return response()->json(['message' => 'No trial class found for this course.'], 404);
    }

    public function completeTrialClass(User $user, Course $course)
    {
        $trialClass = $user->trialClasses()->where('course_id', $course->id)->first();

        if ($trialClass && $trialClass->status !== 'completed') {
            $trialClass->update(['status' => 'completed']);
            return response()->json(['message' => 'Trial class marked as completed.'], 200);
        }

        return response()->json(['message' => 'No active trial class found to complete.'], 404);
    }


    public function startTrial(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = auth()->user(); 
        $existingTrial = TrialClass::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('status', 'pending')
            ->first(); 
        if ($existingTrial) {
            return redirect()->back()->with('error', 'You already have an active trial for this course.');
        }

        // Set trial start and end times
        $trialDuration = 7; // e.g., 7-day trial
        $trialStart = now();
        $trialEnd = now()->addDays($trialDuration); 
        // Create new trial entry
        TrialClass::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'trial_start' => $trialStart,
            'trial_end' => $trialEnd,
        ]);

        return redirect()->route('courses.index')->with('success', 'Trial started successfully!');
    }
}
