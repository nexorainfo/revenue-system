@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.plan.dashboard') }}">

                                गृहपृष्ठ
                            </a>
                        </li>
                        <li class="breadcrumb-item active">वडा अनुसार रसिद रिपोर्ट</li>
                    </ol>
                </div>
                <h4 class="page-title">वडा अनुसार रसिद रिपोर्ट</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">वडा अनुसार रसिद रिपोर्ट</h4>
                        <div class="d-flex gap-1 justify-content-between">
                            <button class="btn btn-sm btn-outline-secondary waves-effect waves-light collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterForm"
                                aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-filter"> फिल्टर</i>
                            </button>
                            <x-html-to-excel file-name="वडा अनुसार रसिद रिपोर्ट" target-table="report-table" />
                            <x-print-button target-element="report-content" title="वडा अनुसार रसिद रिपोर्ट" />
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="collapse show mb-2" id="collapseFilterForm">
                        <form id="report-filter-form" data-bs-url="{{ route('admin.revenue.report.invoice-report') }}">
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
                                    <label for="payment_method" class="form-label">भुक्तानी बिधि</label>
                                    <select name="payment_method"
                                        class="form-select @error('payment_method') is-invalid @enderror"
                                        id="payment_method" data-toggle="select2" data-width="100%">
                                        <option value="">--- छान्नुहोस् ---</option>
                                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>नगद
                                        </option>
                                        <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>बैंक
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="fiscal_year">आर्थिक बर्ष</label>
                                    <select name="fiscal_year[]" multiple data-toggle="select2" id="fiscal_year"
                                        class="form-control">
                                        <option>--- छान्नुहोस् ---</option>
                                        @foreach ($fiscalYears as $fiscalYear)
                                            <option value="{{ $fiscalYear->id }}">{{ $fiscalYear->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" id="submitFormBtn" class="btn btn-primary">
                                पेश गर्नुहोस्
                            </button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <div id="report-content" class="d-none">
                            {!! letterHead() !!}
                            <table id="report-table" class="table table-sm mt-3 table-bordered">
                                <thead>
                                    <tr>
                                        @foreach (officeSetting()->localBody->ward_no as $ward_no)
                                            <th> वडा नं. {{ $ward_no }}</th>
                                        @endforeach
                                        <th>पालिका</th>
                                        <th>जम्मा</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="report_data">

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                function createTable(wardsData, palikaCount) {
                    const row = document.querySelector('#report_data');
                    row.innerHTML = '';

                    // Populate ward counts
                    wardsData.forEach(wardCount => {
                        const td = document.createElement('td');
                        td.innerHTML = wardCount;
                        row.appendChild(td);
                    });

                    // Add पालिका count
                    const palikaTd = document.createElement('td');
                    palikaTd.innerHTML = palikaCount;
                    row.appendChild(palikaTd);

                    // Calculate and add total (including पालिका count)
                    const totalTd = document.createElement('td');
                    totalTd.innerHTML = wardsData.reduce((sum, val) => sum + val, palikaCount);
                    row.appendChild(totalTd);
                }


                // x-csrf protection
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document.body).delegate('#report-filter-form', 'submit', function(e) {
                    e.preventDefault()
                    // get attribute data-bs-url from form and assign it to const variable url
                    const url = $(this).attr('data-bs-url');
                    const submitFormBtn = $("#submitFormBtn");
                    const collapseFilterForm = $("#collapseFilterForm");
                    $.ajax({
                        type: "post",
                        url: url,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            submitFormBtn.prop('disabled', true);
                            submitFormBtn.html("<i class='fa fa-spinner fa-spin'></i>");
                        },
                        success: function(resp) {
                            submitFormBtn.prop('disabled', false);
                            collapseFilterForm.collapse('hide');
                            submitFormBtn.html("पेश गर्नुहोस्");
                            $('#report-content').removeClass('d-none');
                            // Pass both wardsData and palikaCount to the createTable function
                            createTable(resp.wardsData, resp.palikaCount);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            submitFormBtn.prop('disabled', false)
                            submitFormBtn.html("पेश गर्नुहोस्");
                            toastMessage('error', XMLHttpRequest.responseJSON.message)
                        }
                    });
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
