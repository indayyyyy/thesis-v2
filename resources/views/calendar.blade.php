<!DOCTYPE html>
<html>
<head>
    <title>Fullcalender</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; padding-bottom:10px">
        <div>
            @hasanyrole('writer|admin')
            <h1>Calendar Schedule</h1>

            @else
            <h1>My Schedule</h1>
            @endhasanyrole
        </div>

        <div>
            <!-- Button trigger modal -->
                <button type="button" class="btn bg-gradient-primary btn mb-0 " data-toggle="modal" data-target="#exampleModal">
                   Create Appointment
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Patient Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            @error('custom_validation') <div class="text-danger">{{ $message }}</div> @enderror
                            @if (auth()->user()->hasRole('patient'))
                                <form  method="POST" action="{{ route('create_sched_patient') }}" role="form text-left">
                                    @csrf
                                    @else
                            <form  method="POST" action="{{ route('create_sched') }}" role="form text-left">
                                 @csrf
                                @endif

                                @if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('admin'))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user-name" class="form-control-label">{{ __('Full Name') }}</label>
                                            <div class="@error('name')border border-danger rounded-3 @enderror">
                                                <input name="name" class="form-control" type="text" placeholder="Name"
                                                    id="user-name">
                                            </div>
                                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                            <div class="@error('email')border border-danger rounded-3 @enderror">
                                                <input name="email" class="form-control" type="email"
                                                    placeholder="@example.com" id="user-email">
                                            </div>
                                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    @if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('admin'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user.phone" class="form-control-label">{{ __('Phone') }}</label>
                                            <div class="@error('phone')border border-danger rounded-3 @enderror">
                                                <input name="phone" class="form-control" type="tel"
                                                    placeholder="40770888444" id="phone">
                                            </div>
                                            @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location" class="form-control-label">{{ __('Appointment Date') }}</label>
                                            <div class="@error('date_of_appointment') border border-danger rounded-3 @enderror">
                                                <input name="date_of_appointment" type="date" class="form-control" type="text"
                                                    placeholder="Location" id="name">
                                            </div>
                                            @error('date_of_appointment') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="@error('date_of_appointment') border border-danger rounded-3 @enderror">
                                            <label>
                                                Appointment Time
                                            </label>

                                            <select  class="form-control" name="time_type">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select>
                                        </div>
                                        @error('time_type') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="@error('date_of_appointment') border border-danger rounded-3 @enderror">
                                            <label>
                                                Case Description
                                            </label>
                                            <select  class="form-control" name="case_category_id">
                                                @php
                                                    $case_categories = App\Models\CaseCategory::all();
                                                @endphp
                                            @foreach ($case_categories as $case)
                                                <option value="{{ $case->id }}">{{ $case->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('time_type') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                @if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('admin'))
                                <div class="form-group">
                                    <label for="location">{{ 'Location' }}</label>
                                    <div class="@error('location')border border-danger rounded-3 @enderror">
                                        <textarea name="location" class="form-control" id="location" rows="3"
                                         ></textarea>
                                    </div>
                                    @error('location') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                @endif
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    </div>
                </div>
        </div>
    </div>

    <div id='calendar'></div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
        @if (count($errors) > 0)
            $('#exampleModal').modal('show');
        @endif
        </script>

<script>
$(document).ready(function () {

var SITEURL = "{{ url('/') }}";

$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    events: SITEURL + "/fullcalender",
                    displayEventTime: true,
                    editable: true,
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                                event.allDay = true;
                        } else {
                                event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: false,
                    select: function (start, end, allDay) {
                        var title = alert('Are you Sure To Create This Schedule?');
                        // if (title) {
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                            $.ajax({
                                url: SITEURL + "/fullcalenderAjax",
                                data: {
                                    start: start,
                                    end: end,
                                    type: 'add'
                                },
                                type: "POST",
                                success: function (data) {
                                    displayMessage("Schedule Created Successfully");

                                    calendar.fullCalendar('renderEvent',
                                        {
                                            id: data.id,
                                            start: start,
                                            end: end,
                                            allDay: allDay
                                        },true);

                                    calendar.fullCalendar('unselect');
                                }
                            });
                        // }
                    },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                        $.ajax({
                            url: SITEURL + '/fullcalenderAjax',
                            data: {
                                title: event.title,
                                start: start,
                                end: end,
                                id: event.id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                                displayMessage("Event Updated Successfully");
                            }
                        });
                    },
                    // eventClick: function (event) {
                    //     var deleteMsg = confirm("Do you really want to delete?");
                    //     if (deleteMsg) {
                    //         $.ajax({
                    //             type: "POST",
                    //             url: SITEURL + '/fullcalenderAjax',
                    //             data: {
                    //                     id: event.id,
                    //                     type: 'delete'
                    //             },
                    //             success: function (response) {
                    //                 calendar.fullCalendar('removeEvents', event.id);
                    //                 displayMessage("Schedule Deleted Successfully");
                    //             }
                    //         });
                    //     }
                    // }

                });
});

function displayMessage(message) {
    toastr.success(message, 'Event');
}

</script>

</body>
</html>
