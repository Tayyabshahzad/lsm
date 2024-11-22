@extends('layouts.front.theme')
@section('content')
    <div class="container-xxl bg-primary newsletter py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <p class="section-title text-white justify-content-center"><span></span>Newsletter<span></span></p>
                    <h1 class="text-center text-white mb-4">Stay Always In Touch</h1>
                    <p class="text-white mb-4">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore. Clita
                        erat ipsum et lorem et sit sed stet lorem sit clita duo justo</p>
                    <form action="{{ route('courses.startTrial') }}" method="post">
                        @csrf
                    <div class="position-relative w-100 mt-3 mb-4">
                        <select class="form-control border-0 rounded-pill w-100 ps-4 pe-5"  name="course" id="" style="height: 48px;">
                            @foreach ($courses as $course )
                                    <option value="{{ $course->id }}"> {{ $course->title }} </option>
                            @endforeach
                        </select>
                        
                    </div>

                    <div class="  mt-10 text-center">
                        <button type="submit" style="background: #fff" class="btn rounded-pill py-2 px-4 ms-3   d-lg-block"> Start Trail </button>
                        
                    </div>

                </form>
 
                </div>
            </div>
        </div>
    </div>
@endsection
