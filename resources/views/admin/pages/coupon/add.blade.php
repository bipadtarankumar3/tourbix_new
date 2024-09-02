@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
        <form action="{{ isset($coupon) ? URL::to('admin/coupon/add-action/' . $coupon->id) : URL::to('admin/coupon/add-action') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <h5 class="card-header">General</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="coupon_code">Coupon Code</label>
                                        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Coupon Code" value="{{ isset($coupon) ? $coupon->coupon_code : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="coupon_name">Coupon Name</label>
                                        <input type="text" class="form-control" id="coupon_name" name="coupon_name" placeholder="Coupon Name" value="{{ isset($coupon) ? $coupon->coupon_name : '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="coupon_amount">Coupon Amount</label>
                                        <input type="text" class="form-control" id="coupon_amount" name="coupon_amount" placeholder="Coupon Amount" value="{{ isset($coupon) ? $coupon->coupon_amount : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount_type">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="form-control" required>
                                            <option value="">--select--</option>
                                            <option value="flat" {{ isset($coupon) && $coupon->discount_type == 'flat' ? 'selected' : '' }}>Flat</option>
                                            <option value="percentage" {{ isset($coupon) && $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="feature_image">Feature Image</label>
                                        <input type="file" class="form-control" id="feature_image" name="feature_image" placeholder="Image">
                                        @if(isset($coupon) && $coupon->feature_image)
                                            <img src="{{ asset($coupon->feature_image) }}" alt="Feature Image" width="50" class="mt-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="End Date" value="{{ isset($coupon) ? $coupon->end_date : '' }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <h5 class="card-header">Usage Restriction</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="min_spend">Minimum Spend</label>
                                        <input type="text" class="form-control" id="min_spend" name="min_spend" placeholder="Minimum Spend" value="{{ isset($coupon) ? $coupon->min_spend : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_spend">Maximum Spend</label>
                                        <input type="text" class="form-control" id="max_spend" name="max_spend" placeholder="Maximum Spend" value="{{ isset($coupon) ? $coupon->max_spend : '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="only_for_services">Only For Services</label>
                                        <select name="only_for_services" id="only_for_services" class="form-control" >
                                            <option value="">--select--</option>
                                            <option value="">Yes</option>
                                            <option value="">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="only_for_user">Only For User</label>
                                        <select name="only_for_user" id="only_for_user" class="form-control" >
                                            <option value="">--select--</option>
                                            <option value="">Yes</option>
                                            <option value="">No</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <h5 class="card-header">Usage Limits</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usage_limit_per_coupon">Usage Limit Per Coupon</label>
                                        <input type="text" class="form-control" id="usage_limit_per_coupon" name="usage_limit_per_coupon" placeholder="Usage Limit Per Coupon" value="{{ isset($coupon) ? $coupon->usage_limit_per_coupon : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usage_limit_per_user">Usage Limit Per User</label>
                                        <input type="text" class="form-control" id="usage_limit_per_user" name="usage_limit_per_user" placeholder="Usage Limit Per User" value="{{ isset($coupon) ? $coupon->usage_limit_per_user : '' }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <h5 class="card-header">Publish</h5>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="form-check mb-2">
                                    <input type="radio" id="status_draft" name="status" class="form-check-input" value="Draft" {{ isset($coupon) && $coupon->status == 'draft' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="status_draft">Draft</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="status_publish" name="status" class="form-check-input" value="Publish" {{ isset($coupon) && $coupon->status == 'publish' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="status_publish">Publish</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($coupon) ? 'Update' : 'Submit' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
