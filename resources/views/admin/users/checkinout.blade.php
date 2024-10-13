<!-- In resources/views/admin/users/checkinout.blade.php -->

@extends('admin.app')
@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Check-In/Out Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.view-admin') }}">User Management</a></li>
                    <li class="breadcrumb-item active">Check-In/Out Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Check-In/Out Details for {{ $user->name }}</h4>
                    <a href="{{ route('admin.users.export', $user->id) }}" class="btn btn-primary float-right">Export to Excel</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table" id="checkinout-table">
                                <thead>
                                    <tr>
                                        <th>Check-In Time</th>
                                        <th>Check-Out Time</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be appended here via DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<!-- Include moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function () {
        var userId = "{{ $user->id }}";

        // Initialize DataTable with server-side processing
        var table = $('#checkinout-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/users/' + userId + '/details',
                type: 'GET',
                error: function(xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                { 
                    data: 'check_in', 
                    name: 'check_in',
                    render: function(data, type, row) {
                        return moment(data).format('DD MMM YYYY, HH:mm:ss');
                    }
                },
                { 
                    data: 'check_out', 
                    name: 'check_out',
                    render: function(data, type, row) {
                        return moment(data).format('DD MMM YYYY, HH:mm:ss');
                    }
                },
                { 
                    data: null, 
                    name: 'duration', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        var checkIn = moment(row.check_in);
                        var checkOut = moment(row.check_out);
                        var duration = moment.duration(checkOut.diff(checkIn));
                        var hours = parseInt(duration.asHours());
                        var minutes = parseInt(duration.asMinutes()) % 60;
                        var seconds = parseInt(duration.asSeconds()) % 60;
                        return hours + 'h ' + minutes + 'm ' + seconds + 's';
                    }
                }
            ]
        });
    });
</script>
@endsection
