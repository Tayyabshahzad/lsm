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
                    <h6 class="m-0 font-weight-bold text-uppercase">{{ __('Testimonial Create') }}</h6>
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



                        <form action="{{ route('testimonials.store') }}" method="POST" >
                            @csrf
                            <div class="form-group">
                                <label >Name</label>
                                <input type="text" name="name" required class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Email</label>
                                <input type="email" name="email" required class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Position</label>
                                <input type="text" name="position" class="form-control">
                            </div>

                            <div>
                                <label>Message</label>
                                <textarea name="message" required class="form-control"></textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Rating</label>
                                <select name="rating" required class="form-control">
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                                @error('rating')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label>{{ __('Image') }}</label>
                                @livewire('services.media.uploadable',[
                                'file' => $file->file ?? '',
                                'path' => 'testimonials',
                                'target' => 'testimonials'
                                ]) 
                            </div>


                            <hr>
                            <button type="submit" class="form-control btn btn-success btn-sm">Submit Testimonial</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    @endsection
