@extends('web.layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <h4 class="alert-heading">Payment Successful!</h4>
                <p>Your payment was processed successfully, and your booking is confirmed. Thank you for choosing us!</p>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Booking Confirmation</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Booking Details</h6>
                    <ul class="list-unstyled">
                        <li><strong>Booking ID:</strong> 123456</li>
                        <li><strong>Name:</strong> John Doe</li>
                        <li><strong>Email:</strong> john.doe@example.com</li>
                        <li><strong>Mobile:</strong> +1 234 567 890</li>
                        <li><strong>Room ID:</strong> 789</li>
                        <li><strong>Insurance:</strong> Yes</li>
                        <li><strong>Payment Method:</strong> Credit Card</li>
                        <li><strong>Amount Paid:</strong> $199.99</li>
                        <li><strong>Booking Date:</strong> September 5, 2024, 3:00 pm</li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
