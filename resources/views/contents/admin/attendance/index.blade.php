@extends('layouts.admin')


@section("content")
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
                                <th>
                                    <form action="{{ route('attendance.checkIn') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info">Check In</button>
                                    </form> 
                                </th>
                                <th>
                                    <form action="{{ route('attendance.checkOut') }}" method="POST">
                                        @csrf
                                        <button type="submit"  class="btn btn-sm btn-danger">Check Out</button>
                                    </form>
                                </th>
                            </tr>
                        </thead>
                    </table> 
                </div>
            </div>
        </div>
    </div>


    @endsection
