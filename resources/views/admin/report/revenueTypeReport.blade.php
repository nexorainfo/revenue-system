@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
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
                            <x-html-to-excel file-name="राजस्व रिपोर्ट" target-table="report_table" />
                            <x-print-button target-element="report_table" title="राजस्व रिपोर्ट" :header-required="true" />
                        </div>
                    </div>
                </div>
                <div class="card-body px-0">
                    <div class="collapse show mb-2" id="collapseFilterForm">
                        <form id="report-filter-form" data-bs-url="{{ route('admin.revenue.report.report-data') }}">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <x-date-input-component name_ne="from_date" label_ne="मिति देखि" name_en="en_from_date"
                                                            label_en="From Date" :get-today-date="false" />
                                </div>
                                <div class="col-md-3">
                                    <x-date-input-component name_ne="to_date" label_ne="मिति सम्म" name_en="en_to_date"
                                                            label_en="To Date" :get-today-date="false" />
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="fiscal_year">आर्थिक बर्ष</label>
                                    <select name="fiscal_year" id="fiscal_year"
                                            class="form-control">
                                        <option disabled>--- छान्नुहोस् ---</option>
                                        @foreach ($fiscalYears as $fiscalYear)
                                            <option value="{{ $fiscalYear->id }}">{{ $fiscalYear->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2 d-flex gap-1">
                                    <div class="col">
                                        <label for="payment_method" class="form-label">भुक्तानी बिधि</label>
                                        <select name="payment_method"
                                                class="form-select @error('payment_method') is-invalid @enderror"
                                                id="payment_method" >
                                            <option value="" {{ old('payment_method') == '' ? 'selected' : '' }}>-- select ---
                                            </option>
                                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>नगद
                                            </option>
                                            <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>बैंक
                                            </option>
                                        </select>
                                        @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                            </div>
                            <button type="submit" id="submitFormBtn" class="btn btn-primary">
                                पेश गर्नुहोस्
                            </button>

                        </form>
                    </div>
                    <div id="report_table" class="table-responsive"></div>
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
