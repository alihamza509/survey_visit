@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Trial Order Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('trial_orders.index') }}">Trial Orders</a></li>
                    <li class="breadcrumb-item active">Trial Order Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="card">
    <div class="card-header">
        <h4 class="card-title">Trial Order Details</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <!-- Left Column for Text Details -->
                <div class="col-md-6 col-sm-12 mb-2">
                    <p><strong>Shop Name:</strong> {{ $trialOrder->shop->shop_name }}</p>
                    <p><strong>User Name:</strong> {{ $trialOrder->user->name }}</p>
                    <p><strong>Types of Order:</strong> {{ $trialOrder->types_of_order }}</p>
                    <p><strong>Potential Order Horizon:</strong> {{ $trialOrder->potential_order_horizon }}</p>
                </div>

                <!-- Right Column for Image and Additional Text -->
                <div class="col-md-6 col-sm-12 mb-2 text-center">
                    <p><strong>Order Quantity:</strong> {{ $trialOrder->order_quantity }}</p>
                    <p><strong>Order Delivery Calendar:</strong> {{ $trialOrder->order_delivery_calendar }}</p>
                    <p><strong>Meeting Discussion Summary:</strong> {{ $trialOrder->meeting_discussion_summary }}</p>
                    <p><strong>Photo Display of Battu:</strong></p>
                    @if($trialOrder->photo_display_of_battu)
                        <img src="{{ asset('storage/' . $trialOrder->photo_display_of_battu) }}" 
                             alt="Photo Display of Battu" 
                             class="img-fluid img-thumbnail" 
                             style="max-width: 100%; height: auto; max-height: 400px;">
                    @else
                        <p>No Photo</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
