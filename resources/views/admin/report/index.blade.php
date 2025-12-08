@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.plan.dashboard') }}">
                                <img class="icon me-1" src="{{ asset('assets/backend/images/home.svg') }}" alt="document-icon">
                                गृहपृष्ठ
                            </a>
                        </li>
                        <li class="breadcrumb-item active">राजस्व रिपोर्ट</li>
                    </ol>
                </div>
                <h4 class="page-title">राजस्व रिपोर्ट </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-0">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">राजस्व रिपोर्ट</h4>
                        <div class="d-flex gap-1 justify-content-between">
                            <button class="btn btn-sm btn-outline-secondary waves-effect waves-light collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterForm"
                                aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-filter"> फिल्टर</i>
                            </button>
                            <x-html-to-excel file-name="राजस्व रिपोर्ट" target-table="report-table" />
                            <x-print-button target-element="report-table" title="राजस्व रिपोर्ट" :header-required="true" />
                        </div>
                    </div>
                </div>
                <div class="card-body px-0">
                    <div class="collapse show mb-2" id="collapseFilterForm">
                        <form id="report-filter-form" data-bs-url="{{ route('admin.revenue.report.report-data') }}">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <x-date-input-component nameNe="from_date" labelNe="मिति देखि" nameEn="en_from_date"
                                        labelEn="From Date" :get-today-date="false" />
                                </div>
                                <div class="col-md-3">
                                    <x-date-input-component nameNe="to_date" labelNe="मिति सम्म" nameEn="en_to_date"
                                        labelEn="To Date" :get-today-date="false" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="fiscal_year">आर्थिक बर्ष</label>
                                    <select name="fiscal_year[]" multiple data-toggle="select2" id="fiscal_year"
                                        class="form-control">
                                        <option disabled>--- छान्नुहोस् ---</option>
                                        @foreach ($fiscalYears as $fiscalYear)
                                            <option value="{{ $fiscalYear->id }}">{{ $fiscalYear->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="ward_no">वडा नं.</label>
                                    <select name="ward_no[]" multiple data-toggle="select2" id="ward_no"
                                        class="form-control">
                                        <option disabled>--- छान्नुहोस् ---</option>
                                        @foreach ($officeSetting->localBody->ward_no as $ward)
                                            <option value="{{ $ward }}">{{ $ward }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <fieldset class="border p-2 mb-2">
                                <legend class="font-16 text-info">
                                    <strong>
                                        Columns
                                    </strong>
                                </legend>
                                <div class="row">
                                    @foreach ($columnData as $columns)
                                        <div class="col-md-3 mb-2">
                                            <label for="column.{{ $columns['table_name'] }}">{{ $columns['name'] }}</label>
                                            <select name="columns[{{ $columns['table_name'] }}][]"
                                                id="column.{{ $columns['table_name'] }}" multiple data-toggle="select2"
                                                class="form-control">
                                                <option disabled>--- छान्नुहोस् ---</option>
                                                @foreach ($columns['columns'] as $column)
                                                    <option value="{{ $column['column'] ?? '' }}">
                                                        {{ $column['name'] ?? '' }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                            <button type="submit" id="submitFormBtn" class="btn btn-primary">
                                पेश गर्नुहोस्
                            </button>

                        </form>
                    </div>
                    <div id="report-table" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/backend/js/ajaxCall.js') }}"></script>
        <script>
            $(document).ready(function() {
                // x-csrf protection
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document.body).delegate('#plan_area_id', 'change', function(e) {
                    let plan_area_id = $('#plan_area_id').val()
                    $('#plan_sub_area_id').html('<option disabled>--- छान्नुहोस् ---</option>')
                    if (!plan_area_id.length) {
                        return false;
                    }
                    $.ajax({
                        type: 'get',
                        data: {
                            plan_area_id: plan_area_id
                        },
                        url: "{{ route('admin.plan.planSubArea') }}",
                        success: function(resp) {
                            $(resp.data).each(function(key, data) {
                                $('#plan_sub_area_id').append("<option value=" + data.id +
                                    ">" + data.area_name + "</option>")
                            })
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastMessage('error', XMLHttpRequest.responseJSON.message)
                        }
                    })
                })

                $(document.body).delegate('#plan_level_id', 'change', function(e) {
                    let plan_level_id = $('#plan_level_id').val()
                    $('#plan_sub_level_id').html('<option disabled>--- छान्नुहोस् ---</option>')
                    if (!plan_level_id.length) {
                        return false;
                    }
                    $.ajax({
                        type: 'get',
                        data: {
                            plan_level_id: plan_level_id
                        },
                        url: "{{ route('admin.plan.planSubLevel') }}",
                        success: function(resp) {
                            $(resp.data).each(function(key, data) {
                                $('#plan_sub_level_id').append("<option value=" + data.id +
                                    ">" + data.level_name + "</option>")
                            })
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastMessage('error', XMLHttpRequest.responseJSON.message)
                        }
                    })
                })

                $(document.body).delegate('#budget_head_id', 'change', function(e) {
                    let budget_head_id = $('#budget_head_id').val()
                    $('#budget_sub_head_id').html('<option disabled>--- छान्नुहोस् ---</option>')
                    if (!budget_head_id.length) {
                        return false;
                    }
                    $.ajax({
                        type: 'get',
                        data: {
                            budget_head_id: budget_head_id
                        },
                        url: "{{ route('admin.plan.budgetSubHead') }}",
                        success: function(resp) {
                            $(resp.data).each(function(key, data) {
                                $('#budget_sub_head_id').append("<option value=" + data.id +
                                    ">" + data.title + "</option>")
                            })
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastMessage('error', XMLHttpRequest.responseJSON.message)
                        }
                    })
                })

                function toastMessage(type, title) {
                    swal.fire({
                        title: title,
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        width: 450,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: type,
                    });
                }
            });
        </script>
    @endpush
@endsection
