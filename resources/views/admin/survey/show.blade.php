@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Survey Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('surveys.index') }}">Surveys</a></li>
                    <li class="breadcrumb-item active">Survey Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section id="survey-details">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Survey Details</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <td>{{ $survey->id }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $survey->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Shop Name</th>
                                <td>{{ $survey->shop_name }}</td>
                            </tr>
                            <tr>
                                <th>Owner Name</th>
                                <td>{{ $survey->owner_name }}</td>
                            </tr>
                            <tr>
                                <th>Owner Phone</th>
                                <td>{{ $survey->owner_phone }}</td>
                            </tr>
                            <tr>
                                <th>Owner Email</th>
                                <td>{{ $survey->owner_email }}</td>
                            </tr>
                            <tr>
                                <th>Geo Location</th>
                                <td>{{ $survey->geo_location }}</td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td>{{ $survey->comments }}</td>
                            </tr>
                            <tr>
                                <th>Cement Brands</th>
                                <td>{{ $survey->cement_brands }}</td>
                            </tr>
                            <tr>
                                <th>Other Products</th>
                                <td>{{ $survey->other_products }}</td>
                            </tr>
                            <tr>
                                <th>Photo 1</th>
                                <td>
                                    @if($survey->photo_1)
                                        <img src="{{ asset('storage/' . $survey->photo_1) }}" alt="Photo 1" style="max-width: 200px;">
                                    @else
                                        No photo available
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Photo 2</th>
                                <td>
                                    @if($survey->photo_2)
                                        <img src="{{ asset('storage/' . $survey->photo_2) }}" alt="Photo 2" style="max-width: 200px;">
                                    @else
                                        No photo available
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Photo 3</th>
                                <td>
                                    @if($survey->photo_3)
                                        <img src="{{ asset('storage/' . $survey->photo_3) }}" alt="Photo 3" style="max-width: 200px;">
                                    @else
                                        No photo available
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
