@extends('admin.layouts.master')
@section('content')
    <div class="row mt-2">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-6 col-xl-3 border-end">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-sm bg-blue rounded-circle">
                                    <i class="fas fa-clipboard-list avatar-title font-18 text-white"></i>
                                </div>
                                <h3 class="mt-1 mb-0"><span data-plugin="counterup">{{ $invoiceCount }}</span></h3>
                                <p class="text-muted font-15 mb-0 text-truncate"
                                   title="आ.व. {{ officeSetting()->fiscalYear->title ?? '' }}मा काटिएको नगदी रसिद">
                                    आ.व. {{ officeSetting()->fiscalYear->title ?? '' }}मा काटिएको नगदी रसिद</p>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3 border-end">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-sm bg-blue rounded-circle">
                                    <i class="fas fa-rupee-sign avatar-title font-18 text-white"></i>
                                </div>
                                <h3 class="mb-0 mt-1"><span data-plugin="counterup">{{ $fiscal_year_total }}</span></h3>
                                <p class="text-muted font-15 mb-0">चालु आर्थिक वर्षको संकलन राजस्व</p>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-sm bg-blue rounded-circle">
                                    <i class="fas fa-rupee-sign avatar-title font-18 text-white"></i>
                                </div>
                                <h3 class="mb-0 mt-1"><span data-plugin="counterup">{{ $all_total }}</span></h3>
                                <p class="text-muted font-15 mb-0">कुल राजस्व</p>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <div class="row mt-2">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="avatar-md bg-blue rounded-circle">
                                <i class="fas fa-rupee-sign avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="my-1"><span data-plugin="counterup">{{ $today_total }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">आजको </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <div class="avatar-md bg-success rounded-circle">
                                <i class="fas fa-rupee-sign avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="text-end">
                                <h3 class="my-1">रु. <span data-plugin="counterup">{{ $this_month_total }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">चालु महिनाको</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <div class="avatar-md bg-info rounded-circle">
                                <i class="fas fa-rupee-sign avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="text-end">
                                <h3 class="my-1">रु. <span data-plugin="counterup">{{ $previous_month_total }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">गत महिनाको</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div>
    </div>
    <div class="row mt-2" id="charts" data-chart-url="{{ route('admin.dashboard.ajax') }}">
        <div class="col-md-6">
            <div class="card">
                <h4>
                    कुल राजस्व विवरण
                </h4>
                <div class="card-body">
                    <canvas id="totalRevenue" chart-type="pie"></canvas>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h4>
                    भुक्तानी अनुसार कुल राजस्व विवरण
                </h4>
                <div class="card-body">
                    <canvas id="totalCashBankRevenue" chart-type="pie"></canvas>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <h4>
                    महिना अनुसार कुल राजस्व विवरण
                </h4>
                <div class="card-body">
                    <canvas id="accordingToMonth" chart-type="bar"></canvas>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <h4>
                    चालु आर्थिक वर्षाका अनुसार कुल राजस्व
                </h4>
                <div class="card-body">
                    <canvas id="accordingToFy" chart-type="bar"> </canvas>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/backend/js/chart.js') }}"></script>
        <script type="module" src="{{ asset('assets/backend/js/chartInit.js') }}"></script>
    @endpush
@endsection
