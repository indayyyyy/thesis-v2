<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}

    <title></title>
  </head>
  <body>

<!-- Button trigger modal -->
<button type="button" class="btn bg-gradient-primary btn-sm mb-0" data-toggle="modal" data-target="#exampleModal">
    +&nbsp; New User
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form  method="POST" action="{{ route('create_sched') }}" role="form text-left">
                @csrf

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
                    <div class="col-md-12">
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
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="location" class="form-control-label">{{ __('Appointment Date') }}</label>
                            <div class="@error('date_of_appointment') border border-danger rounded-3 @enderror">
                                <input name="date_of_appointment" type="date" class="form-control" type="text"
                                    placeholder="Location" id="name">
                            </div>
                            @error('date_of_appointment') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div> --}}

                    <div class="mb-3">
                        <div class="@error('date_of_appointment') border border-danger rounded-3 @enderror">
                            <label>
                                User Type
                            </label>

                            <select  class="form-control" name="role">
                                <option value="doctor">Doctor</option>
                                <option value="admin">Admin</option>
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


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
