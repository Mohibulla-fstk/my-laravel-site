@extends('backEnd.layouts.master')
@section('title','All Users')
@section('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="page-title">All Users</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Active Status</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">
                        @php
                        $roleOrder = [
                            'Admin','Moderator','Editor','Salesman','Analyst','Manager','Support',
                            'Guest','SuperAdmin','Developer','Accountant','HR','Marketing','Analitics',
                        ];

                        $roleColors = [
                            'Admin'        => 'bg-danger',
                            'Moderator'    => 'bg-warning',
                            'Editor'       => 'bg-primary',
                            'Salesman'     => 'bg-success',
                            'Analyst'      => 'bg-info',
                            'Manager'      => 'bg-secondary',
                            'Support'      => 'bg-dark text-white',
                            'Guest'        => 'bg-green text-white',
                            'SuperAdmin'   => 'bg-danger text-white',
                            'Developer'    => 'bg-indigo text-white',
                            'Accountant'   => 'bg-pink text-white',
                            'HR'           => 'bg-blue text-white',
                            'Marketing'    => 'bg-orange text-dark',
                            'Analitics'    => 'bg-info',
                        ];
                        @endphp

                        @foreach($users as $user)
                        <tr id="user-{{ $user->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($user->image) }}" style="width:50px;height:auto;">
                            </td>
                            <td>
                                <span style="font-weight: bold">{{ $user->name }}</span> <br>
                                <p>{{ $user->company_position }}</p>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                $sortedRoles = collect($user->roles)
                                    ->sortBy(fn($r) => array_search($r->name, $roleOrder));
                                @endphp

                                @foreach($sortedRoles as $role)
                                    <span class="badge {{ $roleColors[$role->name] ?? 'bg-info' }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span class="badge bg-secondary" id="status-{{ $user->id }}">
                                @php
                                    $lastActivity = $user->last_activity ? \Carbon\Carbon::parse($user->last_activity) : $user->updated_at;
                                @endphp
                                {{ now()->diffInSeconds($lastActivity) <= 300 ? 'Active now' : $lastActivity->diffForHumans() }}
                            </span>


                            </td>
                            <td>
                                @if($user->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Blocked by Admin</span>
                                @endif
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
@endsection

@section('script')

<!-- third party js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function fetchUserStatus() {
    $.get("{{ route('users.status') }}", function(users){
        users.forEach(function(user){
            let lastActivity = new Date(user.last_activity || user.updated_at);
            let now = new Date();
            let diff = (now - lastActivity)/1000;
            let statusText = '';
            let badgeClass = 'bg-secondary';

            if(diff <= 300){
                statusText = 'Active now';
                badgeClass = 'bg-success';
            } else {
                let minutes = Math.floor(diff/60);
                if(minutes < 60){
                    statusText = minutes + 'm ago';
                } else {
                    let hours = Math.floor(minutes/60);
                    if(hours < 24){
                        statusText = hours + 'h ago';
                    } else {
                        let days = Math.floor(hours/24);
                        if(days < 7){
                            statusText = days + 'd ago';
                        } else if(days < 30){
                            let weeks = Math.floor(days/7);
                            statusText = weeks + 'w ago';
                        } else {
                            let months = Math.floor(days/30);
                            statusText = months + 'mo ago';
                        }
                    }
                }
            }

            $('#status-' + user.id).text(statusText).removeClass().addClass('badge '+badgeClass);
        });
    });
}

$(document).ready(function(){
    // page load এ current user last_activity update
    $.post("{{ route('users.updateActivity') }}", {_token: '{{ csrf_token() }}'});

    // প্রথম fetch
    fetchUserStatus();

    // Update current user last_activity every 10 seconds
    setInterval(function() {
        $.post("{{ route('users.updateActivity') }}", {_token: '{{ csrf_token() }}'});
    }, 10000);

    // Fetch all users status every 5 seconds
    setInterval(fetchUserStatus, 5000);
});
</script>


<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->




@endsection

