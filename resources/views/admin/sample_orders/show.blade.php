@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Sample Order Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sample-orders.index') }}">Sample Orders</a></li>
                    <li class="breadcrumb-item active">Sample Order Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID:</strong> {{ $sampleOrder->id }}</p>
                                <p><strong>Shop ID:</strong> {{ $sampleOrder->shop->shop_name }}</p>
                                <p><strong>Sample Order:</strong> {{ $sampleOrder->sample_order }}</p>
                                <p><strong>GST Details:</strong> {{ $sampleOrder->GST_details }}</p>
                                <p><strong>Comments of Meeting:</strong> {{ $sampleOrder->comments_of_meeting }}</p>
                                <!-- Add more fields as needed -->
                            </div>
                            <div class="col-md-6">
                                @if ($sampleOrder->photo_of_product)
                                <img src="{{ asset('storage/' . $sampleOrder->photo_of_product) }}" alt="Product Photo" class="img-fluid">
                                @else
                                <p>No photo available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
