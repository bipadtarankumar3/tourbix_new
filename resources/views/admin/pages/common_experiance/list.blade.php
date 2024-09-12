@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
    {{ Request::segment(2) . '/' . Request::segment(3) }}
</h6>
<div class="row">
   
    <div class="col-md-12">
      <div class="card">
          <div class="card-body">
            <div class="float-right my-2 text-right" style="text-align: right">
              <a href="{{URL::to('admin/experiance/add')}}"><button type="button" class="btn btn-warning">Add Exprience</button></a>
              {{-- <a href="{{URL::to('admin/room/avalibility')}}"><button type="button" class="btn btn-success">Avalibility</button></a> --}}
              
          </div>
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
                      <td>{!! $pkg->description !!}</td>
                      <td>{{ $pkg->amount }}</td>
                      <td>{{ $pkg->created_at }}</td>
                      <td>
                          <a href="{{ URL::to('admin/experiance/edit', $pkg->id) }}"><i class="fa fa-solid fa-pen-to-square"></i></a>
                          <a href="{{ URL::to('admin/experiance/delete', $pkg->id) }}" onclick="deleteConfirmation(event)"><i class="fa fa-solid fa-trash"></i></a>
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
