@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}
        </h6>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h4 class="card-header">{{ isset($location) ? 'Update Location' : 'Add Location' }}</h4>
                    <div class="card-body">
                        <form action="{{ isset($location) ? URL::to('admin/location/update-action') : URL::to('admin/location/add-action') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if(isset($location))
                                <input type="hidden" name="id" value="{{ $location->id }}">
                            @endif
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" placeholder="Location Name" name="location_name" class="form-control" value="{{ isset($location) ? $location->location_name : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="parent">Parent</label>
                                <select name="location_category_id" class="form-control" id="parent">
                                    <option value="">--Please Select--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ isset($location) && $location->location_category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="location_description" class="ckeditor form-control">{{ isset($location) ? $location->location_description : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="location_image" class="form-control">
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">{{ isset($location) ? 'Update' : 'Add' }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="zero_config">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($locations as $key => $location)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $location->location_name }}</td>
                                            <td>{{ $location->status }}</td>
                                            <td>{{ $location->created_at }}</td>
                                            <td>
                                                <a href="{{URL::To('admin/location/edit',$location->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{ URL::To('admin/location/delete', $location->id) }}" onclick="deleteConfirmation(event)"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
        console.error( error );
        });
    </script>
@endsection
