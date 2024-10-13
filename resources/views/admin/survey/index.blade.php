@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Surveys</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Surveys</li>
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
                    <h4 class="card-title">Survey List</h4>
                    <a href="{{ route('surveys.export') }}" class="btn btn-primary float-right">Export to Excel</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table" id="surveys-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Shop Name</th>
                                        <th>Owner Name</th>
                                        <th>Owner Phone</th>
                                        <th>Owner Email</th>
                                        <th>Geo Location</th>
                                        <th>Comments</th>
                                        <th>Cement Brands</th>
                                        <th>Other Products</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surveys as $survey)
                                        <tr>
                                            <td>{{ $survey->id }}</td>
                                            <td>{{ $survey->user->name }}</td>
                                            <td>{{ $survey->shop_name }}</td>
                                            <td>{{ $survey->owner_name }}</td>
                                            <td>{{ $survey->owner_phone }}</td>
                                            <td>{{ $survey->owner_email }}</td>
                                            <td>{{ $survey->geo_location }}</td>
                                            <td>{{ $survey->comments }}</td>
                                            <td>{{ $survey->cement_brands }}</td>
                                            <td>{{ $survey->other_products }}</td>
                                            <td>
                                                <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-info btn-sm">View</a>
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
        $('#surveys-table').DataTable();
    });
</script>
@endsection
