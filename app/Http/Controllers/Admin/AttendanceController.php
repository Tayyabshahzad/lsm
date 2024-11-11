<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF; // If using a PDF library like barryvdh/laravel-dompdf
use Maatwebsite\Excel\Facades\Excel; // If using Laravel Excel for exports

class AttendanceController extends Controller
{
    // Display all attendance records with optional filtering
    public function index(Request $request)
    {
         
        $query = Attendance::with('user'); // Eager load user data  
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } 
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        } 
        if ($request->filled('status')) {
            $query->where('is_present', $request->status === 'present' ? 1 : 0);
        } 
        $attendances = $query->paginate(20); // Adjust pagination as needed
        $users = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->get();

        return view('contents.admin.attendances.index', compact('attendances', 'users'));
    }

    // Show details of a specific attendance record
    public function show($id)
    {
        $attendance = Attendance::with('user')->findOrFail($id);
        return view('contents.admin.attendances.show', compact('attendance'));
    }

    // Show form to edit an attendance record
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $users = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->get();
        return view('contents.admin.attendances.edit', compact('attendance', 'users'));
    }

    // Update an attendance record
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        if ($request->has('check_in_time') && $request->check_in_time) {
            $request->merge([
                'check_in_time' => \Carbon\Carbon::createFromFormat('H:i', $request->check_in_time)->format('H:i:s')
            ]);
        } 
        if ($request->has('check_out_time') && $request->check_out_time) {
            $request->merge([
                'check_out_time' => \Carbon\Carbon::createFromFormat('H:i', $request->check_out_time)->format('H:i:s')
            ]);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in_time' => 'date_format:H:i:s',
            'check_out_time' => 'date_format:H:i:s',
            'is_present' => 'required|boolean',
            'remarks' => 'nullable|string',
        ]);

        $attendance->update($request->all()); 
         
        return redirect()->route('admin.attendances.index')->with('success', 'Attendance updated successfully.');
    }

    // Delete an attendance record
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('admin.attendances.index')->with('success', 'Attendance deleted successfully.');
    }

    // Optional: Generate attendance reports
    public function report(Request $request)
    {
        // Implement report generation logic
        // For example, generate a PDF or view summary statistics

        // Example: Generate PDF of attendance records
        $attendances = Attendance::with('user')->get();
        $pdf = PDF::loadView('admin.attendances.report', compact('attendances'));
        return $pdf->download('attendance_report.pdf');
    }

    // Optional: Export attendance data
    public function export(Request $request)
    {
        // Implement export logic, e.g., export to CSV using Laravel Excel
        return Excel::download(new \App\Exports\AttendancesExport, 'attendances.xlsx');
    }
}
