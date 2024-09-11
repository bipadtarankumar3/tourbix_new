@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
    {{ Request::segment(2) . '/' . Request::segment(3) }}
</h6>
<div class="row">
    <div class="col-md-3">
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

              <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type="number" step="0.01" placeholder="Amount" name="amount" value="{{ isset($package) ? $package->amount : '' }}" class="form-control">
              </div>

              <button class="btn btn-primary mt-2" type="submit">{{ isset($package) ? 'Update' : 'Add New' }}</button>
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
                  <th>Title</th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($lists as $key => $pkg)
                  <tr>
                      <th scope="row">{{ $key+1 }}</th>
                      <td>{{ $pkg->title }}</td>
                      <td>{{ $pkg->description }}</td>
                      <td>{{ $pkg->amount }}</td>
                      <td>{{ $pkg->created_at }}</td>
                      <td>
                          <a href="{{ URL::to('admin/experiance-package/edit', $pkg->id) }}"><i class="fa fa-solid fa-pen-to-square"></i></a>
                          <a href="{{ URL::to('admin/experiance-package/delete', $pkg->id) }}" onclick="deleteConfirmation(event)"><i class="fa fa-solid fa-trash"></i></a>
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
