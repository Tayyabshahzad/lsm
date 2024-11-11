@extends('layouts.admin')


@section("content")



<div>
    @can('course.index')
    <div class="card">
        <div class="card-header">
            <h3>@lang('List Attendance Records ')</h3>
        </div>
    </div>
    <div class="row mt-4 mb-4">

        <div class="col-12">
            <div class="card border-left-primary shadow">
                
                <div class="card-footer text-center">  
                    <form method="GET" class="form-inline" action="{{ route('admin.attendances.index') }}"> 
                        <div class="form-group mb-2 ml-4"> 
                            <input type="date" name="date" value="{{ request('date') }}"  class="form-control" id="staticEmail" > 
                        </div> 
                        <div  class="form-group mb-2 ml-4">  
                            <select name="user_id" class="form-control">
                                <option value="">All Students</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div  class="form-group mb-2 ml-4"> 
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            </select>
                        </div>

                        <div  class="form-group ml-4 mb-2"> 
                            <button type="submit" class="btn-sm btn btn-info">Filter</button>
                        </div>

                        {{-- <div  class="form-group ml-4 mb-2"> 
                            <a href="{{ route('admin.attendances.export') }}" class="btn btn-sm btn-info">Export to Excel</a>
                        </div>
                        <div  class="form-group ml-4 mb-2"> 
                            <a href="{{ route('admin.attendances.report') }}" class="btn btn-sm btn-warning">Download PDF Report</a>
                        </div>  --}}
                    </form>  
                </div> 
            </div>
        </div>   
    </div>  
    <div class="row mt-4 mb-4"> 
        <div class="col-12">
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <table border="1" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Date</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Present</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->id }}</td>
                                    <td>{{ $attendance->user->name }}</td>
                                    <td>{{ $attendance->date }}</td>
                                    <td>{{ $attendance->check_in_time ?? 'N/A' }}</td>
                                    <td>{{ $attendance->check_out_time ?? 'N/A' }}</td>
                                    <td>{{ $attendance->is_present ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a  class="btn btn-sm btn-info" href="{{ route('admin.attendances.show', $attendance->id) }}">
                                            View
                                        </a>
                                        
                                        <a class="btn btn-sm btn-warning" href="{{ route('admin.attendances.edit', $attendance->id) }}">Edit</a>
                                        <form action="{{ route('admin.attendances.destroy', $attendance->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this attendance record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-red">No attendance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>  
            </div>
        </div> 

    </div> 
    @endcan
    
</div>

 
@endsection
