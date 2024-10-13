@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Follow-Ups</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Follow-Ups</li>
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
                    <h4 class="card-title">Follow-Up List</h4>
                    <a href="{{ route('follow_ups.export') }}" class="btn btn-primary float-right">Export to Excel</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table" id="follow-ups-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Shop Name</th>
                                        <th>User Name</th>
                                        <th>Trial Order</th>
                                        <th>Potential Order Horizon</th>
                                        <th>Payment Preference</th>
                                        <th>Comments of Meeting</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($followUps as $followUp)
                                        <tr>
                                            <td>{{ $followUp->id }}</td>
                                            <td>{{ $followUp->shop->shop_name }}</td>
                                            <td>{{ $followUp->user->name }}</td>
                                    
                                            <td>{{ $followUp->trial_order }}</td>
                                            <td>{{ $followUp->potential_order_horizon }}</td>
                                            <td>{{ $followUp->payment_preference }}</td>
                                            <td>{{ $followUp->comments_of_meeting }}</td>
                                            <td>
                                                <a href="{{ route('follow_ups.show', $followUp->id) }}" class="btn btn-info btn-sm">View</a>
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
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#follow-ups-table').DataTable();
    });
</script>
@endsection
