@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Trial Orders</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Trial Orders</li>
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
                    <h4 class="card-title">Trial Order List</h4>
                    <a href="{{ route('trial_orders.export') }}" class="btn btn-primary float-right">Export to Excel</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table" id="trial-orders-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Shop Name</th>
                                        <th>User Name</th>
                                        <th>Photo Display of Battu</th>
                                        <th>Types of Order</th>
                                        <th>Potential Order Horizon</th>
                                        <th>Order Quantity</th>
                                        <th>Order Delivery Calendar</th>
                                        <th>Meeting Discussion Summary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trialOrders as $trialOrder)
                                        <tr>
                                            <td>{{ $trialOrder->id }}</td>
                                            <td>{{ $trialOrder->shop->shop_name }}</td>
                                            <td>{{ $trialOrder->user->name }}</td>
                                            <td>
                                                @if($trialOrder->photo_display_of_battu)
                                                    <a href="{{ asset('storage/' . $trialOrder->photo_display_of_battu) }}" target="_blank">View Photo</a>
                                                @else
                                                    No Photo
                                                @endif
                                            </td>
                                            <td>{{ $trialOrder->types_of_order }}</td>
                                            <td>{{ $trialOrder->potential_order_horizon }}</td>
                                            <td>{{ $trialOrder->order_quantity }}</td>
                                            <td>{{ $trialOrder->order_delivery_calendar }}</td>
                                            <td>{{ $trialOrder->meeting_discussion_summary }}</td>
                                            <td>
                                                <a href="{{ route('trial_orders.show', $trialOrder->id) }}" class="btn btn-info btn-sm">View</a>
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
        $('#trial-orders-table').DataTable();
    });
</script>
@endsection
