@extends('admin.app')

@section('content')
<section id="dashboard-analytics">
    <div class="row">
        <!-- SurveyVisit Tile -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-eye font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">{{ $surveyVisitCount }}</h2>
                        <p class="card-text">Survey Visits</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SampleOrder Tile -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-package font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">{{ $sampleOrderCount }}</h2>
                        <p class="card-text">Sample Orders</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FollowUp Tile -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-repeat font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">{{ $followUpCount }}</h2>
                        <p class="card-text">Follow Ups</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TrialOrder Tile -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-check font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">{{ $trialOrderCount }}</h2>
                        <p class="card-text">Trial Orders</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Tile -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-dollar-sign font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">{{ $expenseCount }}</h2>
                        <p class="card-text">Expenses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphs Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dashboard Analytics</h4>
                </div>
                <div class="card-body">
                    <!-- ApexCharts Graph Container -->
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                height: 350,
                type: 'line'
            },
            series: [{
                name: 'Survey Visits',
                data: {!! json_encode($surveyVisitData) !!}
            }, {
                name: 'Sample Orders',
                data: {!! json_encode($sampleOrderData) !!}
            }, {
                name: 'Follow Ups',
                data: {!! json_encode($followUpData) !!}
            }],
            xaxis: {
                categories: {!! json_encode($months) !!}
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>
@endsection

