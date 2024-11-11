<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
    //    $attendances = Attendance::with('user')->orderBy('created_at','desc')->get(); 
        return view('contents.admin.attendance.index');
    }
    public function checkIn(Request $request) {
        $today = Carbon::today();
        $userId = auth()->id(); 
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            return redirect()->route('attendance.index')->with('warning', 'You have already checked in today.');
        }
 
        Attendance::create([
            'user_id' => $userId,
            'date' => $today,
            'check_in_time' => Carbon::now(),
            'is_present' => true,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Checked in successfully.');
    }

    public function checkOut(Request $request) { 
        $today = Carbon::today();
        $userId = auth()->id();  
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first(); 
        if (!$attendance) {
            return redirect()->route('attendance.index')->with('danger', 'You need to check in first.');
        } 
        if ($attendance->check_out_time) {
            return redirect()->route('attendance.index')->with('warning', 'You have already checked out today.');
        }

        // Mark check-out time
        $attendance->update([
            'check_out_time' => Carbon::now(),
        ]);

        return redirect()->route('attendance.index')->with('success', 'Checked out successfully.');
    }

    public function viewAttendance() {  
        $attendances = Attendance::where('user_id', auth()->id())->get(); 
        return view('contents.admin.attendance.view', compact('attendances'));
    }
    public function teacherAttendance()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })
        ->whereDoesntHave('attendances', function ($query) {
            $query->whereDate('date', now());
        })
        ->get();
        return view('contents.admin.teacher.attendance.index', compact('users'));
    }


    public function storeAttendance(Request $request)
    {

        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'date' => now()->toDateString(),
            'check_in_time' => now()->toTimeString(),
            'is_present' => true,
        ]);


        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }

    public function markAttendance(Request $request)
    {

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })
        ->whereDoesntHave('attendances', function ($query) {
            $query->whereDate('date', now());
        })
        ->get();
        return view('contents.admin.teacher.attendance.index', compact('users'));

    }

    public function markedAttendance(){
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })
        ->whereHas('attendances', function ($query) {
            $query->whereDate('date', now());
        })
        ->get();

        return view('contents.admin.teacher.attendance.marked', compact('users'));
    }
    // Mark check-out time for the user's attendance
    public function checkOut2($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update(['check_out_time' => now()->toTimeString()]);

        return redirect()->back()->with('success', 'Check-out marked successfully.');
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
        //
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
}
