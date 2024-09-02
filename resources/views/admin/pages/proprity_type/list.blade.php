@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>{{ Request::segment(2) . '/' . Request::segment(3) }}</h6>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h4 class="card-header">{{$title}}</h4>
                    <div class="card-body">
                        <form action="{{ isset($propertyType) ? URL::to('admin/hotel/property-type/edit-action/' . $propertyType->id) : URL::to('admin/hotel/property-type/add-action') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Property Type Name</label>
                                <input type="text" placeholder="Property Type Name" name="property_type" class="form-control" required>
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">{{ isset($propertyType) ? 'Update' : 'Add New' }}</button>
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
                                    @foreach ($propertyTypes as $key => $propertyType)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $propertyType->property_type }}</td>
                                            <td style="color: green">Publish</td>
                                            <td>{{ $propertyType->created_at }}</td>
                                            <td>
                                                <a href="{{ URL::to('admin/hotel/property-type/edit', $propertyType->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{ URL::to('admin/hotel/property-type/delete', $propertyType->id) }}" onclick="deleteConfirmation(event)"><i class="fa-solid fa-trash"></i></a>
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
@endsection
