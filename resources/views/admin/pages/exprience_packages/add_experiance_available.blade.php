@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
        {{ Request::segment(2) . '/' . Request::segment(3) }}

    </h6>

    <form action="{{  url('admin/room/update_roomavailable') }}" method="POST" enctype="multipart/form-data" class="browser-default-validation">
        @csrf
        <input type="hidden" name="experiance_id" id="experiance_id" class="experiance_id" value="{{$Experiance->id}}">
        <div class="row ">
            <div class="col-md-12">
                <div class="card p-4">
                    
                        
                        <div class="row mb-3">
                            <div class="col-md-12 float-right" style="text-align: right">
                                 <!-- Calendar -->
                                 <button type="button" id="getMonthBtn" class="btn btn-primary">Add Month For Availibility</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                 <!-- Calendar -->
                                    <div id='calendar'></div>
                            </div>
                        </div>
                       
                        

                        <div class="row">
                            <div class="col-md-12">
                                {{-- <button class="btn btn-primary mt-2" type="submit">Update</button> --}}
                                <a href="{{URL::to('admin/experiance/list')}}">
                                    <button class="btn btn-success mt-2" type="button">Back</button>

                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>


<!-- Modal for editing availability -->
 
    <!-- Edit Availability Modal -->
    <div class="modal fade" id="editAvailabilityModal" tabindex="-1" aria-labelledby="editAvailabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAvailabilityModalLabel">Edit Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAvailabilityForm">
                    <div class="modal-body">
                        <input type="hidden" id="modalId" name="id">
                        <input type="hidden" id="modalDate" name="date">
                        <div class="mb-3">
                            <label for="modalAmount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="modalAmount" name="amount">
                        </div>
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label">Status</label>
                            <select class="form-select" id="modalStatus" name="status">
                                <option value="available">Available</option>
                                <option value="unavailable">Not Available</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Initialize FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '{{ $Experiance->month }}-01',
            events: [
                @foreach($ExperianceAvailable as $data)
                {
                    id: '{{ $data->id }}',
                    title: '{{ $data->exprience_package_available_status === "available" ? "Available - ₹" . $data->exprience_package_amount : "Not Available - ₹" . $data->exprience_package_amount }}',
                    start: '{{ $data->exprience_package_available_date }}',
                    allDay: true,
                    color: '{{ $data->exprience_package_available_status === "available" ? "#28a745" : "#dc3545" }}', // Green for available, Red for not available
                    extendedProps: {
                        amount: '{{ $data->exprience_package_amount }}',
                        status: '{{ $data->exprience_package_available_status }}'
                    }
                },
                @endforeach
            ],
            dateClick: function(info) {
                // Handle date click (show modal for creating new event)
            },
            eventClick: function(info) {
                var event = info.event;
                var props = event.extendedProps;

                // Populate the modal with event data
                document.getElementById('modalId').value = event.id;
                document.getElementById('modalDate').value = event.startStr;
                document.getElementById('modalAmount').value = props.amount;
                document.getElementById('modalStatus').value = props.status;

                // Show the modal
                var myModal = new bootstrap.Modal(document.getElementById('editAvailabilityModal'));
                myModal.show();

                // Handle form submission
                document.getElementById('editAvailabilityForm').onsubmit = function(e) {
                    e.preventDefault();

                    var data = new FormData(e.target);
                    fetch("{{ URL::to('/admin/experiance-package/add_experiance_package_update_availability') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: data.get('id'),
                            amount: data.get('amount'),
                            status: data.get('status')
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the event on the calendar
                            event.setProp('title', data.status === 'YES' ? 'Available - ₹' + data.amount : 'Not Available - ₹' + data.amount);
                            event.setProp('color', data.status === 'YES' ? '#28a745' : '#dc3545'); // Update color based on status

                            // Hide the modal, show alert, and reload the page
                            myModal.hide();
                            alert('Availability updated successfully!');
                            window.location.reload(); // Reload the page
                        }
                    })
                    .catch(error => {
                        console.error('Error updating availability:', error);
                        alert('Failed to update availability.');
                    });
                };
            }
        });

        calendar.render();
        // Add button to get current calendar month
        document.getElementById('getMonthBtn').addEventListener('click', function() {
            var currentMonth = calendar.getDate();

            // Format the month to always have two digits (e.g., '01', '02')
            var formattedMonth = currentMonth.getFullYear() + '-' + ('0' + (currentMonth.getMonth() + 1)).slice(-2);

            var experiance_id = $('.experiance_id').val();
            
            // Perform AJAX request with the current month
            fetch("{{ URL::to('/admin/experiance-package/update_experiance_package_available_month') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    month: formattedMonth,
                    experiance_id: experiance_id,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Month updated successfully!');

                    // Reload the page after showing the alert
                    window.location.reload();
                } else {
                    // If success is false, show an error message
                    alert('Failed to update month.');
                }
            })
            .catch(error => {
                console.error('Error fetching month data:', error);
            });
        });

    });
</script>

 


@endsection