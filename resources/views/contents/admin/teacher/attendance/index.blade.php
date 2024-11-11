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
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ now()->toDateString() }}</td> <!-- Current date -->
                                <td>N/A</td> <!-- No check-in time initially -->
                                <td>N/A</td> <!-- No check-out time initially -->
                                <td>No</td> <!-- Not present initially -->

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No users available to mark attendance.</td>
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
