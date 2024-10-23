@extends('admin.app')

@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper col-12">
                <h3 class="content-header-title float-left mb-0">Expense Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.expenses.index') }}">Expenses</a></li>
                    <li class="breadcrumb-item active">Expense Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Expense Detail</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $expense->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $expense->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Expense</th>
                                        <td>{{ $expense->date_of_expense }}</td>
                                    </tr>
                                    <tr>
                                        <th>Expense Detail</th>
                                        <td>{{ $expense->expense_detail }}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Photo</th>
                                        <td>
                                            @if($expense->invoice_photo)
                                                <img src="{{ asset('storage/' . $expense->invoice_photo) }}" alt="Invoice Photo" class="img-fluid img-thumbnail" style="max-width: 200px;">
                                            @else
                                                <p>No photo available</p>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <a href="{{ route('admin.expenses.index') }}" class="btn btn-primary">Back to Expenses</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
