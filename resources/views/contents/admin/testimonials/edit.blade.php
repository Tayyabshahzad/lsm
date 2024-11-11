@extends('layouts.admin')


@section('content')
    <div class="row">
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <div class="col-12">
            <div class="card shadow mb-4 border-bottom-primary">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-uppercase">{{ __('Testimonial Update') }}</h6>

                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                            <div class="dropdown-header">{{ __('Action') }}</div>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('testimonials.index') }}">
                                <i class="fas fa-arrow-left pr-2"></i>
                                {{ __(" Back ") }}
                            </a>

                        </div>
                    </div>
                </div>


                <!-- Card Body -->
                <div class="card-body">
                    <div class="text">

                        <form action="{{ route('testimonials.update', $testimonial) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div>
                                <label>Name</label>
                                <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" class="form-control" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email', $testimonial->email) }}" class="form-control" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label>Position</label>
                                <input type="text" name="position" class="form-control"  value="{{ old('position', $testimonial->position) }}">
                            </div>

                            <div>
                                <label>Status</label>
                                <select name="approved" required class="form-control">
                                    <option value="1" {{ $testimonial->approved == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $testimonial->approved == 0 ? 'selected' : '' }}>In Active</option>

                                </select>
                            </div>

                            <div>
                                <label>Message</label>
                                <textarea name="message" class="form-control" required>{{ old('message', $testimonial->message) }}</textarea>
                                @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label>Rating</label>
                                <select name="rating" required class="form-control">
                                    <option value="1" {{ $testimonial->rating == 1 ? 'selected' : '' }}>1 Star</option>
                                    <option value="2" {{ $testimonial->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                                </select>
                                @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>

                            <button type="submit" class="btn btn-warning btn-sm">Update Testimonial</button>
                        </form>





                    </div>
                </div>
            </div>
        </div>
    @endsection
