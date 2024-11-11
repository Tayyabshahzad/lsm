@extends('layouts.admin')


@section("content")
<div class="row">


    <div class="col-12">
        <div class="card shadow mb-4 border-bottom-primary">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-uppercase">{{ __('Testimonials') }}</h6>

                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                        <div class="dropdown-header">{{ __('Action') }}</div>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('testimonials.create') }}">
                            <i class="fas fa-arrow-right pr-2"></i>
                            {{ __(" Create ") }}
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Rating</th>
                            <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($testimonials as $testimonial)
                            <tr>
                                <td>{{ $testimonial->name }}</td>
                                <td>{{ $testimonial->email }}</td>
                                <td>{{ $testimonial->position }}</td>
                                <td>{{ $testimonial->approved == 1 ? 'Active' : 'In Active'}}</td>
                                <td>{{ $testimonial->approved == 1 ? 'Active' : 'In Active'}}</td>
                                <td>
                                @for ($i = 1; $i <= $testimonial->rating; $i++)
                                    ★
                                @endfor
                                @for ($i = $testimonial->rating + 1; $i <= 5; $i++)
                                    ☆
                                @endfor
                            </td>
                                <td>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ __('Action') }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                                            <div class="dropdown-header">{{ __('Action') }}</div>
                                            <div class="dropdown-divider"></div>

                                            <a class="dropdown-item" href="{{ route('testimonials.edit', $testimonial) }}">
                                                <i class="fas fa-arrow-right pr-2"></i>
                                                {{ __(" Edit ") }}
                                            </a>

                                            <a class="dropdown-item" href="{{ route('attendances.mark') }}">
                                                <i class="fas fa-arrow-right pr-2"></i>


                                                <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</button>
                                                </form>

                                            </a>



                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No Testimonial available.</td>
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
