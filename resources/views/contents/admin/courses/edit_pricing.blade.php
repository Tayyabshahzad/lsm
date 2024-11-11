@extends('layouts.admin')


@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card shadow mb-4 border-bottom-primary">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-uppercase">{{ __('Pricing Edit') }}</h6> 
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="{{ route('pricings.index') }}"     >
                             Back
                        </a>
                        
                    </div>
                </div>


                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-center">


                        <form action="{{ route('course.pricing.update', $course->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                    
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Price</th>
                                        <th>Billing Cycle</th>
                                        <th>Classes per Week</th>
                                        <th>Duration (mins)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="pricingDetailsBody">
                                    @foreach ($pricings as $pricing)
                                    <tr>
                                        <td><input type="text" name="pricings[{{ $loop->index }}][price]" value="{{ $pricing->price }}" class="form-control" required></td>
                                        <td>
                                            <select name="pricings[{{ $loop->index }}][billing_cycle]" class="form-control" required>
                                                <option value="Monthly" {{ $pricing->billing_cycle === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="Quarterly" {{ $pricing->billing_cycle === 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                <option value="Yearly" {{ $pricing->billing_cycle === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="pricings[{{ $loop->index }}][classes_per_week]" value="{{ $pricing->classes_per_week }}" class="form-control" required></td>
                                        <td><input type="number" name="pricings[{{ $loop->index }}][course_duration]" value="{{ $pricing->course_duration }}" class="form-control" required></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="removePricing(this)">Remove</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <button type="button" class="btn btn-primary" onclick="addPricing()">Add Pricing</button>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </form> 

                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
           
           function addPricing() {
        const newRow = `
            <tr>
                <td><input type="text" name="pricings[new][price]" class="form-control" required></td>
                <td>
                    <select name="pricings[new][billing_cycle]" class="form-control" required>
                        <option value="Monthly">Monthly</option>
                        <option value="Quarterly">Quarterly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                </td>
                <td><input type="number" name="pricings[new][classes_per_week]" class="form-control" required></td>
                <td><input type="number" name="pricings[new][course_duration]" class="form-control" required></td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removePricing(this)">Remove</button>
                </td>
            </tr>
        `;
        $('#pricingDetailsBody').append(newRow);
    }

    function removePricing(button) {
        $(button).closest('tr').remove();
    }
        </script>
    @endsection
