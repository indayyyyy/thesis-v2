    <main>
      <div class="container-fluid py-4">
       {{-- Tables --}}
          <div class="row">
              <div class="col-12">
                  <div class="card mb-4">
                      <div class="card-header pb-0">
                          <h6>Appointment List</h6>
                      </div>
                      <div class="card-body px-0 pt-0 pb-2">
                          <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                  <thead>
                                  <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Patient Name</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Schedule Date</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Schedule</th>
                                      <th class="text-secondary opacity-7">Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @forelse ($appointments as $item)
                                      <tr>
                                          <td>
                                              <div class="d-flex px-2 py-1">
                                                  {{-- <div>
                                                      <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                                  </div> --}}
                                                  <div class="d-flex flex-column justify-content-center">
                                                      <h6 class="mb-0 text-sm">{{ $item->user->name }}</h6>
                                                      <p class="text-xs text-secondary mb-0">{{ $item->user->email }}</p>
                                                  </div>
                                              </div>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->start)->diffForHumans() }}</p>
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
                                              <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">

                                              </a>
                                              @if ($item->status === 'pending')
                                                <form method="POST" action="{{ route('send_sms') }}">
                                                     @csrf
                                                    @method('post')
                                                    <input type="hidden" name="user_id" value={{$item->user->id}}>
                                                    <input type="hidden" name="start" value={{$item->start}}>
                                                    <button type="submit" class="btn btn-default">Approve Application</button>
                                                </form>
                                              @elseif($item->status === 'approved')
                                                    {{-- approved --}}
                                                    @else

                                                    {{-- decline --}}
                                              @endif

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
