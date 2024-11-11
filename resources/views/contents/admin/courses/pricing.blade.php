@extends('layouts.admin')


@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card shadow mb-4 border-bottom-primary">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-uppercase">{{ __('Course Pricing') }}</h6>


                </div>


                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-center">


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Course Title') }}</th>
                                    <th scope="col">{{ __('Department') }}</th>
                                    <th scope="col">{{ __('Pricing') }}</th>
                                    @if (Auth::user()->hasRole('Super-Admin') || Auth::user()->hasAnyPermission(['course.edit', 'course.delete']))
                                        <th scope="col">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ $course->pricings->count() }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" 
                                            data-toggle="modal" 
                                            data-target="#addPricingModal"
                                            data-course-id="{{ $course->id }}"
                                            data-pricings="{{ json_encode($course->pricings) }}">
                                                View Pricing
                                            </button> 
 
                                        </td>
                                         
                                        <td>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                                                    <div class="dropdown-header">{{ __('Actions') }}:</div>
                                                    <a  class="p-2" href="{{ route('course.pricing.edit', $course->id) }}" >
                                                        Edit Pricing
                                                    </a>

                                                    
                                                    
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr />
                        <div class="text-center">
                            {{ $courses->links() }} <!-- Pagination links -->
                        </div>



                        <!-- Modal Structure -->
                        <div class="modal fade" id="addPricingModal" tabindex="-1" role="dialog"
                            aria-labelledby="addPricingModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content  g">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPricingModalLabel">View Pricing</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                     
                                        <div class="modal-body">
                                            <table class="table table-border" >
                                                <thead>
                                                    <tr>
                                                        <th>Price</th>
                                                        <th>Billing Cycle</th>
                                                        <th>Classes per Week</th>
                                                        <th>Duration (mins)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pricingDetailsBody">
                                                    <!-- Pricing details will be injected here -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            
                                        </div>
                                     
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
           
            $(document).ready(function() { 
                $('#addPricingModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var courseId = button.data('course-id'); // Extract info from data-* attributes
                    var pricings = button.data('pricings'); // Get the pricing data  
                    var pricingDetailsBody = $('#pricingDetailsBody');
                    pricingDetailsBody.empty(); 
                    // Populate pricing details
                    if (pricings.length > 0) {
                        $.each(pricings, function(index, pricing) {
                            pricingDetailsBody.append(`
                                <tr>
                                    <td>${pricing.price}</td>
                                    <td>${pricing.billing_cycle}</td>
                                    <td>${pricing.classes_per_week}</td>
                                    <td>${pricing.course_duration}</td>
                                </tr>
                            `);
                        });
                    } else {
                        pricingDetailsBody.append(`
                            <tr>
                                <td colspan="4" class="text-center">No pricing available for this course.</td>
                            </tr>
                        `);
                    }
                });
            });
        </script>
    @endsection
