@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
     

        <div class="mb-2">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="col-md-2">
                    <a href="{{URL::To('admin/coupon/add')}}" class="btn btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i> Add
                        New</a>
                       
                </div>
            </div>


        </div>
        <div class="card">
            {{-- <h5 class="card-header">{{ $title }}</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th>Coupon Code</th>
                            <th>Actions</th>
                            <th>Coupon Name</th>
                            <th>Coupon Amount</th>
                            <th>Discount Type</th>
                            <th>Feature Image</th>
                            <th>End Date</th>
                            <th>Min Spend</th>
                            <th>Max Spend</th>
                            <th>Only for Services</th>
                            <th>Only for User</th>
                            <th>Usage Limit Per Coupon</th>
                            <th>Usage Limit Per User</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->coupon_code }}</td>
                        <td>
                            <a href="{{ URL::to('admin/coupon/edit', $coupon->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ URL::to('admin/coupon/delete', $coupon->id) }}" onclick="deleteConfirmation(event)"><i class="fa-solid fa-trash"></i></a>
                                            
                        </td>
                        <td>{{ $coupon->coupon_name }}</td>
                        <td>{{ $coupon->coupon_amount }}</td>
                        <td>{{ $coupon->discount_type }}</td>
                        <td><img src="{{ asset($coupon->feature_image) }}" alt="Feature Image" width="50"></td>
                        <td>{{ $coupon->end_date }}</td>
                        <td>{{ $coupon->min_spend }}</td>
                        <td>{{ $coupon->max_spend }}</td>
                        <td>{{ $coupon->only_for_services }}</td>
                        <td>{{ $coupon->only_for_user }}</td>
                        <td>{{ $coupon->usage_limit_per_coupon }}</td>
                        <td>{{ $coupon->usage_limit_per_user }}</td>
                        <td>{{ $coupon->status }}</td>
                    </tr>
                @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
