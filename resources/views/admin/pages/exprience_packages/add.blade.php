@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Add Package</h4>
                <div class="card-body">
                    <form
                        action="{{ isset($package) ? URL::To('admin/experiance-package/add-action-package/' . $package->id) : URL::To('admin/experiance-package/add-action-package') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="experience_package" value="{{ isset($package) ? 'update' : 'add' }}">
                        <input type="hidden" name="experience_package_id"
                            value="{{ isset($package) ? $package->id : '' }}">

                        <div class="form-group">
                            <label for="title">Package Title</label>
                            <input type="text" placeholder="Package Title" name="title"
                                value="{{ isset($package) ? $package->title : '' }}" class="form-control">
                        </div>

                        <div class="form-group mt-2">
                            <label for="description">Description</label>
                            <textarea placeholder="Package Description" name="description" class="form-control">{{ isset($package) ? $package->description : '' }}</textarea>
                        </div>
                        <div class="form-floating form-floating-outline mb-4  mt-4">
                            <input type="file" name="feature_image" class="form-control" id="basic-default-name"
                                placeholder="Feature Image">
                            <label for="basic-default-name">Feature Image</label>
                            @if (isset($room) && $room->feature_image)
                                <img src="{{ URL::to('public/' . $room->feature_image) }}" alt="Feature Image"
                                    width="100">
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="basic-default-name">Location</label>
                                <select name="location_id" id="" class="form-control">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            @if (isset($package) && $package->location_id == $location->id) selected @endif>
                                            {{ $location->location_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-md-6">
                                <label for="basic-default-name">Tour Type</label>
                                <select name="category_id" id="" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (isset($package) && $package->category_id == $category->id) selected @endif>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label for="basic-default-name">Top Features</label>
                                <select name="top_feature_id" id="" class="form-control">
                                    @foreach ($top_features as $top_feature)
                                        <option value="{{ $top_feature->id }}"
                                            @if (isset($package) && $package->experiance_attribute_features_id == $top_feature->id) selected @endif>
                                            {{ $top_feature->attribute_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-md-4">
                                <label for="basic-default-name">Travel Style</label>
                                <select name="travel_style_id" id="" class="form-control">
                                    @foreach ($travel_style as $travel_styl)
                                        <option value="{{ $travel_styl->id }}"
                                            @if (isset($package) && $package->experiance_attribute_style_id == $travel_styl->id) selected @endif>
                                            {{ $travel_styl->attribute_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-md-4">
                                @if (isset($package))
                                    @php
                                        // Explode the comma-separated string into an array if $package exists
                                        $selectedFacilities = explode(',', $package->experiance_attribute_facilities_id);
                                    @endphp
                                @endif
                                <label for="basic-default-name">Facilities</label>
                                <select name="facilitie_id[]" id="facilities-select" class="form-control select2" multiple>
                                    @foreach ($facilities as $facilitie)
                                        <option value="{{ $facilitie->id }}"
                                            @if (isset($package) && in_array($facilitie->id, $selectedFacilities)) selected @endif>
                                            {{ $facilitie->attribute_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="0.01" placeholder="Amount" name="amount"
                                        value="{{ isset($package) ? $package->amount : '' }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="amount">Month</label>
                                    <input type="month" name="month"
                                        value="{{ isset($package) ? $package->month : '' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-md-12">
                                <h4>Experience Images</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_body_row">
                                        <!-- Loop through existing images if in edit mode -->

                                        <tr>
                                            <td><input type="text" name="document_text_name[]" class="form-control"
                                                    placeholder="Name"></td>
                                            <td><input type="file" name="document[]" class="form-control"></td>
                                            <td>
                                                <button type="button" onclick="add_more_row()" id="#add-more-row"
                                                    class="btn btn-info waves-effect waves-light"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </td>
                                        </tr>

                                        @if (isset($package))
                                            @foreach ($documents as $image)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="image_id[]"
                                                            value="{{ $image->id }}">
                                                        <input type="text" readonly name="document_text_name_update[]"
                                                            class="form-control" value="{{ $image->text_name }}">
                                                    </td>
                                                    <td>

                                                        <img src="{{ URL::to('public/upload/' . $image->image_name) }}"
                                                            alt="Feature Image" width="40">

                                                    </td>
                                                    <td>
                                                        <button onclick="remove_row_with_data(this,'{{ $image->id }}')"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="fa-solid fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-12">
                                <h4>Package Days</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No Of Days</th>
                                            <th>Select Expriences</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_days_body_row">
                                        <!-- Loop through existing images if in edit mode -->

                                        <tr>
                                            <td><input type="text" name="package_day[]" class="form-control"
                                                    placeholder="Example Day 1"></td>
                                            <td>
                                                <select name="exprience_id[]" id="" class="form-control">
                                                    @foreach ($expriences as $exprience)
                                                        <option value="{{ $exprience->id }}">{{ $exprience->title }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            <td><input type="text" name="package_description[]" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" onclick="add_days_more_row()" id="#add-more-row"
                                                    class="btn btn-info waves-effect waves-light"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </td>
                                        </tr>

                                        @if (isset($exp_pack_days))
                                            @foreach ($exp_pack_days as $exp_pack_day)
                                                <tr>
                                                    <td><input type="text" name="package_day[]"
                                                            value="{{ $exp_pack_day->package_day }}" class="form-control"
                                                            placeholder="Example Day 1"></td>
                                                    <td>
                                                        <select name="exprience_id[]" id=""
                                                            class="form-control">
                                                            @foreach ($expriences as $exprience)
                                                                <option
                                                                    value="@if ($exp_pack_day->exprience_id == $exprience->id) selected @endif {{ $exprience->id }}">
                                                                    {{ $exprience->title }}</option>
                                                            @endforeach

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="package_description[]"
                                                            value="{{ $exp_pack_day->package_description }}"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <button
                                                            onclick="remove_row_with_data(this,'{{ $exp_pack_day->id }}')"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="fa-solid fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Additional form fields, populated with data if in edit mode -->


                        <button class="btn btn-primary mt-2"
                            type="submit">{{ isset($package) ? 'Update' : 'Submit' }}</button>
                        <a href="{{ URL::to('admin/experiance-package/list') }}">
                            <button class="btn btn-success mt-2" type="button">Back</button>

                        </a>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select facilities", // Optional: Add a placeholder
                allowClear: true
            });
        });
    </script>
    <script>
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('textarea'))
            .then(description => {
                console.log('description was initialized', editor);
            })
            .catch(error => {
                console.error('Error during initialization of the editor', error);
            });
    </script>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Remove row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });


        function add_more_row() {
            var newRow = '<tr>' +
                '<td><input type="text" name="document_text_name[]" class="form-control" placeholder="Name"></td>' +
                '<td><input type="file" name="document[]" class="form-control"></td>' +
                '<td><button type="button" class="btn btn-danger waves-effect waves-light remove-row"><i class="fa-solid fa-trash"></i></button></td>' +
                '</tr>';
            $(".table_body_row").append(newRow)
        }

        function add_days_more_row() {
            var newRow = `
         <tr>
            <td><input type="text" name="package_day[]" class="form-control" placeholder="Example Day 1"></td>
                                   <td>
                                                <select name="exprience_id[]" id="" class="form-control">
                                                    @foreach ($expriences as $exprience)
                                                    <option value="{{ $exprience->id }}">{{ $exprience->title }}</option>
                                                    @endforeach
                                                 
                                                </select>
                                            </td>
                                    <td><input type="text" name="package_description[]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger waves-effect waves-light remove-row"><i class="fa-solid fa-trash"></i></button>
            </td>
        </tr>
        `;
            $(".table_days_body_row").append(newRow)
        }

        function remove_row_with_data(get_this, id) {

            $.ajax({
                type: "GET",
                url: "{{ URL::to('admin/experiance-package/delete_room_images/') }}" + "/" +
                    id, // where you wanna post
                data: {
                    'id': ''
                },
                error: function(jqXHR, textStatus, errorMessage) {
                    console.log(errorMessage); // Optional
                },
                success: function(data) {

                }
            });

            $(get_this).closest('tr').remove();


        }
    </script>
@endsection
