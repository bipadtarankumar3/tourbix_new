@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Add Experience Package</h4>
            <div class="card-body">
              <form action="{{ isset($package) ? URL::To('admin/experiance-package/update-action-package/' . $package->id) : URL::To('admin/experiance-package/add-action-package') }}" method="post">
                @csrf
             
                <input type="hidden" name="experience_package" value="{{ isset($package) ? 'update' : 'add' }}">
                <input type="hidden" name="experience_package_id" value="{{ isset($package) ? $package->id : '' }}">
                
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" placeholder="Package Title" name="title" value="{{ isset($package) ? $package->title : '' }}" class="form-control">
                </div>
  
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea placeholder="Package Description" name="description" class="form-control">{{ isset($package) ? $package->description : '' }}</textarea>
                </div>
                <div class="row my-4">
                    <div class="col-md-12">
                        <h4>Exptience Images</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table_body_row">
                                <!-- Loop through existing images if in edit mode -->

                                <tr>
                                    <td><input type="text" name="document_text_name[]" class="form-control" placeholder="Name"></td>
                                    <td><input type="file" name="document[]" class="form-control"></td>
                                    <td>
                                        <button type="button" onclick="add_more_row()" id="#add-more-row" class="btn btn-info waves-effect waves-light"><i class="fa-solid fa-plus"></i></button>
                                    </td>
                                </tr>

                                @if(isset($room))
                                @foreach ($documents as $image)
                                <tr>
                                    <td>
                                        <input type="hidden" name="image_id[]" value="{{ $image->id }}">
                                        <input type="text" readonly name="document_text_name_update[]" class="form-control" value="{{ $image->text_name }}">
                                    </td>
                                    <td>

                                        <img src="{{ URL::to('public/upload/'.$image->image_name) }}" alt="Feature Image" width="40">

                                    </td>
                                    <td>
                                        <button onclick="remove_row_with_data(this,'{{$image->id}}')" class="btn btn-danger waves-effect waves-light"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Additional form fields, populated with data if in edit mode -->
                <div class="form-floating form-floating-outline mb-4">
                    <input type="file" name="feature_image" class="form-control" id="basic-default-name" placeholder="Feature Image">
                    <label for="basic-default-name">Feature Image</label>
                    @if(isset($room) && $room->feature_image)
                    <img src="{{ URL::to('public/'.$room->feature_image) }}" alt="Feature Image" width="100">
                    @endif
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" step="0.01" placeholder="Amount" name="amount" value="{{ isset($package) ? $package->amount : '' }}" class="form-control">
                </div>
  
                <button class="btn btn-primary mt-2" type="submit">{{ isset($package) ? 'Update' : 'Add New' }}</button>
            </form>
          </div>
        </div>
      </div>
  
</div>
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

    function remove_row_with_data(get_this, id) {

        $.ajax({
            type: "GET",
            url: "{{URL::to('admin/room/delete_room_images/')}}" + "/" + id, // where you wanna post
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