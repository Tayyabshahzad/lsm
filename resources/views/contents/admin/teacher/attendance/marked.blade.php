@extends('layouts.admin')


@section("content")
<div class="row">


    <div class="col-12">
        <div class="card shadow mb-4 border-bottom-primary">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-uppercase">{{ __('Attendance') }}</h6>

                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                        <div class="dropdown-header">{{ __('Action') }}</div>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('attendances.mark') }}">
                            <i class="fas fa-arrow-right pr-2"></i>
                            {{ __(" Mark Attendances ") }}
                        </a>

                    </div>
                </div>
            </div>


            <!-- Card Body -->
            <div class="card-body">
                <div class="text-center">


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>User</th>
                            <th>Date</th>
                            <th>Check-in Time</th>
                            <th>Check-out Time</th>
                            <th>Present</th>
                            <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            @foreach ($user->attendances as $attendance)
                                @if ($attendance->date->isToday()) <!-- Ensure you're checking today's attendance -->
                                    <tr>

                                        <td>{{ $user->name }}</td>
                                        <td>{{ $attendance->date->toDateString() }}</td>
                                        <td>{{ $attendance->check_in_time }}</td>
                                        <td>{{ $attendance->check_out_time ?? 'N/A' }}</td>
                                        <td>{{ $attendance->is_present ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <!-- Form to mark attendance -->
                                            <form action="{{ route('attendance.checkout',$attendance->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-danger btn-square" type="submit">Check Out</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5">No attendance marked today.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <hr />


                </div>
            </div>
        </div>
    </div>


    @endsection
