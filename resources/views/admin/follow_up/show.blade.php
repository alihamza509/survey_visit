@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Follow-Up Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('follow_ups.index') }}">Follow-Ups</a></li>
                    <li class="breadcrumb-item active">Follow-Up Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="card">
    <div class="card-header">
        <h4 class="card-title">Follow-Up Details</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <!-- Column for details -->
                <div class="col-md-6 col-sm-12 mb-2">
                    <p><strong>Shop Name:</strong> {{ $followUp->shop->shop_name }}</p>
                    <p><strong>User Name:</strong> {{ $followUp->user->name }}</p>
                    <p><strong>Trial Order:</strong> {{ $followUp->trial_order }}</p>
                    <p><strong>Potential Order Horizon:</strong> {{ $followUp->potential_order_horizon }}</p>
                    <p><strong>Payment Preference:</strong> {{ $followUp->payment_preference }}</p>
                    <p><strong>Comments of Meeting:</strong> {{ $followUp->comments_of_meeting }}</p>
                </div>

                <!-- Column for photo and other details -->
                <div class="col-md-6 col-sm-12 mb-2 text-center">
                    <p><strong>Photo Display of Battu:</strong></p>
                    @if($followUp->photo_display_of_battu)
                        <a href="{{ asset('storage/' . $followUp->photo_display_of_battu) }}" target="_blank">
                            <img src="{{ asset('storage/' . $followUp->photo_display_of_battu) }}" alt="Photo Display of Battu" class="img-fluid img-thumbnail" style="max-width: 100%; height: auto; max-height: 300px;">
                        </a>
                    @else
                        <p>No photo available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
