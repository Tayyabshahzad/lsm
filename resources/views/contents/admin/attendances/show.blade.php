@extends('layouts.admin')


@section("content")



<div>
    @can('course.index')
    <div class="card">
        <div class="card-header">
            <h3>@lang('Attendance Details')</h3>   
        </div>
         
    </div>  
    <div class="row mt-4 mb-4"> 
        <div class="col-12">
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <table border="1" class="table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $attendance->id }}</td>
                            </tr>

                            <tr>
                                <th>Student</th>
                                <td> {{ $attendance->user->name }}</td>
                            </tr>

                            <tr>
                                <th>Date</th>
                                <td> {{ $attendance->date }}</td>
                            </tr>

                            <tr>
                                <th>Check-In Time</th>
                                <td> {{ $attendance->check_in_time ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Check-Out Time</th>
                                <td>{{ $attendance->check_out_time ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Present</th>
                                <td>{{ $attendance->is_present ? 'Yes' : 'No' }}</td>
                            </tr>

                            <tr>
                                <th>Remarks</th>
                                <td>{{ $attendance->remarks ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th colspan="2" class="text-right">
                                    <a href="{{ route('admin.attendances.index') }}">Back to Attendance List</a>
                                </th>
                            </tr>
                        </tbody> 
                    </table>
                </div>  
            </div>
        </div> 

    </div> 
    @endcan
    
</div>

 
@endsection
