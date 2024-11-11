@extends('layouts.admin')


@section('content')
    <div class="row">


        <div class="col-12">
            <div class="card shadow mb-4 border-bottom-primary">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-uppercase">{{ __("Mark Tody's Attendance") }}</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-center">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Check-in Time</th>
                                    <th>Check-out Time</th>
                                    <th>Present</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date }}</td>
                                        <td>{{ $attendance->check_in_time ? $attendance->check_in_time->format('H:i:s') : 'N/A' }}
                                        </td>
                                        <td>{{ $attendance->check_out_time ? $attendance->check_out_time->format('H:i:s') : 'N/A' }}
                                        </td>

                                        <td>{{ $attendance->is_present ? 'Yes' : 'No' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
