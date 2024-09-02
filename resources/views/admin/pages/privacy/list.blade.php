@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>{{ Request::segment(2) . '/' . Request::segment(3) }}</h6>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h4 class="card-header">{{$title}}</h4>
                    <div class="card-body">
                        <form action="{{ isset($privacy) ? URL::to('admin/hotel/privacy/edit-action/' . $privacy->id) : URL::to('admin/hotel/privacy/add-action') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Hotel Privacy Name</label>
                                <input type="text" placeholder="Hotel Privacy Name" name="privacy_name" class="form-control" required>
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">{{ isset($privacy) ? 'Update' : 'Add New' }}</button>
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
                                    @foreach ($privacies as $key => $privacy)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $privacy->privacy_name }}</td>
                                            <td style="color: green">Publish</td>
                                            <td>{{ $privacy->created_at }}</td>
                                            <td>
                                                <a href="{{ URL::to('admin/hotel/privacy/edit', $privacy->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{ URL::to('admin/hotel/privacy/delete', $privacy->id) }}" onclick="deleteConfirmation(event)"><i class="fa-solid fa-trash"></i></a>
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
