@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4">
            <span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}
        </h6>

        <div class="mb-2">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="mb-0">Bookings</h5>
                </div>
                {{-- <div class="col-md-2">
                    <a href="{{ URL::To('admin/booking/add') }}" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a>
                </div> --}}
            </div>
        </div>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            {{-- <th>Hotel Name</th> --}}
                            <th>Room Name</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Booking Date</th>
                            {{-- <th>Action</th> <!-- Adding a new button column --> --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_id }}</td>
                                <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                                <td>{{ $booking->email }}</td>
                                <td>{{ $booking->phone }}</td>
                                {{-- <td>{{ $booking->room->hotel->name ?? 'N/A' }}</td> <!-- Display Hotel Name --> --}}
                                <td>{{ $booking->room->name ?? 'N/A' }}</td> <!-- Display Room Name -->
                                <td>{{ \Carbon\Carbon::parse($booking->check_in_datetime)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_out_datetime)->format('Y-m-d') }}</td>
                                <td>{{ $booking->total_price }}</td>
                                <td>{{ $booking->status }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d H:i:s') }}</td>
                                {{-- <td>
                                    <a href="{{ URL::to('admin/booking/view', $booking->id) }}" class="btn btn-success btn-sm">
                                        View Details
                                    </a>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
