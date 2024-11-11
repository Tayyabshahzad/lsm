@extends('layouts.admin')


@section('content') 
    <div>
        @can('course.index')
            <div class="card">
                <div class="card-header">
                    <h3>@lang('Edit Attendance ')</h3>
                </div>
            </div>
            <div class="row mt-4 mb-4"> 
                <div class="col-12">
                    <div class="card border-left-primary shadow"> 
                        <div class="card-footer text-center"> 

                            <form class="row" action="{{ route('admin.attendances.update', $attendance->id) }}" method="POST">
                                @csrf
                                <div class="col-lg-3 text-left">
                                    <label for="user_id">Student:</label>
                                    <select name="user_id" required class="form-control">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $attendance->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 text-left">
                                    <label for="date">Date:</label> 
                                    <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}" required>
                                </div>                                 
                                <div class="col-lg-3 text-left">
                                    <label for="check_in_time">Check-In Time:</label>
                                    <input type="time" class="form-control" required name="check_in_time" value="{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}">
                                </div>
                            
                                <div class="col-lg-3 text-left">
                                    <label for="check_out_time">Check-Out Time:</label>
                                    <input type="time" class="form-control" required name="check_out_time" value="{{ \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') }}">
                                </div>
                            
                                <div class="col-lg-3 text-left">
                                    <label for="is_present">Is Present:</label>
                                    <select name="is_present" required class="form-control">
                                        <option value="1" {{ $attendance->is_present ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$attendance->is_present ? 'selected' : '' }}>No</option>
                                    </select>
                                </div> 
                                <div class="col-lg-3 text-left">
                                    <label for="remarks">Remarks:</label>
                                    <textarea name="remarks" class="form-control">{{ $attendance->remarks }}</textarea>
                                </div> 
                                <div class="col-lg-12 text-left">
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.attendances.index') }}">Back to Attendance List</a>
                                    <button type="submit" class="btn btn-sm btn-warning">Update Attendance</button>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        @endcan

    </div>


@endsection
