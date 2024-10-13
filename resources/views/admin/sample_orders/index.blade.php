@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Sample Orders</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sample Orders</li>
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
                    <h4 class="card-title">Sample Order List</h4>
                    <a href="{{ route('sample-orders.export') }}" class="btn btn-primary float-right">Export to Excel</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table" id="sample-orders-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Shop </th>
                                        <th>Sample Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sampleOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->shop->shop_name }}</td>
                                        <td>{{ $order->sample_order }}</td>
                                        <td>
                                            <a href="{{ route('sample-orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
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
        $('#sample-orders-table').DataTable();
    });
</script>
@endsection
