<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<main>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Appointment List</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        {{-- <div style="display:flex; justify-content: flex-end" class="px-3">
                            <button type="submit" class="btn btn-simple ">Create Application</button>
                        </div> --}}
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
{{--                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Patient Name</th>--}}
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schedule Time</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                   <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Created</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($appointments as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/sched_icon.png" class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ \Carbon\Carbon::parse($item->user->date_of_appointment)->diffForHumans() }}</h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">{{$item->status}}</span>
                                        </td>
                                          <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-warning">{{$item->time_type}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$item->start}}</span>
                                        </td>
                                        <td class="align-middle">
                                            <!-- Button trigger modal -->
                                            @if ($item->status === 'approved')
                                            cannot edit, already approved
                                            @else
                                            <button type="button" class="btn bg-gradient-dark btn-sm mt-4 mb-4" data-toggle="modal" data-target="#exampleModal-{{ $item->id }}">
                                                Edit
                                             </button>
                                            @endif
                                                <form action="/appointment/{{$item->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn bg-gradient-dark btn-sm  mb-4" data-toggle="modal" >
                                                        Cancel
                                                    </button>
                                                </form>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title xxx</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- @error('custom_validation') <div class="text-danger">{{ $message }}</div> @enderror --}}
                                                            <form  method="POST" action="{{ url('sched/'.$item->id) }}" role="form text-left">
                                                                @csrf
                                                                @method('put')
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <div class="@error('start') border border-danger rounded-3 @enderror">
                                                                            <label>
                                                                                Appointment Date
                                                                            </label>
                                                                            <input name="start" type="date" class="form-control" value="{{ date('Y-m-d',strtotime($item->start))}}" placeholder="Appointment Date"
                                                                                aria-label="start" aria-describedby="start-addon">
                                                                        </div>
                                                                        @error('start') <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <div class="@error('time_type') border border-danger rounded-3 @enderror">
                                                                            <label>
                                                                                Appointment Time
                                                                            </label>

                                                                            <select  class="form-control" name="time_type">
                                                                                @if($item->time_type ==='pm')
                                                                                <option value="am">AM</option>
                                                                                <option value="pm" selected >PM</option>
                                                                                @else
                                                                                <option value="am" selected>AM</option>
                                                                                <option value="pm"  >PM</option>
                                                                                @endif
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
                                                                            @foreach ($case_categories as $case)
                                                                                <option value="{{ $case->id }}"
                                                                                 {{   $case->id == $item->case_category_id ? 'selected' : ''}}
                                                                                    >
                                                                                    {{ $case->name }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        @error('time_type') <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </div>
                                                                </div>


                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <h2 class="text-center">
                                            no data
                                        </h2>
                                    </tr>
                                @endforelse
                                {{ $appointments->links() }}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</script>
