@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <img class="icon me-1" src="{{ asset('assets/backend/images/home.svg') }}" alt="document-icon">
                                गृहपृष्ठ
                            </a>
                        </li>
                            <li class="breadcrumb-item active">नगदी रसिद</li>
                    </ol>
                </div>
                    <h4 class="page-title">नगदी रसिद</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                            <h4 class="header-title">नगदी रसिद</h4>
                            <div class="d-flex gap-2">
                                @can('revenueCategory_create')
                                    <a href="{{ route('admin.revenue.invoice.index') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-list"></i>
                                        नगदी रसिदहरुको सूची
                                    </a>
                                @endcan
                                @can('revenueCategory_create')
                                    <a href="{{ route('admin.revenue.invoice.edit', [$invoice]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit"></i>
                                        सम्पादन र समिक्षा गर्नुहोस्
                                    </a>
                                @endcan
                                <x-print-button target-element="report-table" title="{{ $invoice->invoice_no }}" />
                            </div>


                    </div>
                </div>
                <div class="card-body">
                    <div class="bg-white" id="report-table">


                        {{-- Customer Copy --}}
                        <div>
                            {!! letterHead() !!}
                            <div class="text-center">
                                <h4 class="fw-bold mb-0 text-decoration-underline">नगदी रसिद</h4>
                                <p>(सेवाग्राही प्रति)</p>
                            </div>

                            <div class="info">
                                <p><strong>रसिद नं.:</strong> {{ $invoice->invoice_no }}</p>
                                <p><strong>सेवाग्राहीको नाम:</strong> {{ $invoice->name }}</p>
                                <p><strong>ठेगाना:</strong> {{ $invoice->address }}</p>
                                <p><strong>मिति:</strong> {{ get_nepali_number($invoice->payment_date) }}</p>
                            </div>


                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>बिषय</th>
                                            <th>परिणाम</th>
                                            <th>दर</th>
                                            <th>बक्यौता</th>
                                            <th>जम्मा</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($invoice->invoiceParticulars as $particular)
                                            <tr>
                                                <td>{{ $particular->revenue }}</td>
                                                <td><x-convert-to-unicode number="{{ $particular->quantity }}" /></td>
                                                <td>रु.<x-convert-to-unicode number="{{ $particular->rate }}" /></td>
                                                <td>रु.<x-convert-to-unicode number="{{ $particular->due_amount }}" /></td>
                                                <td>रु.<x-convert-to-unicode number="{{ $particular->grand_total_amount }}" /></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-right">जम्मा</th>
                                            <td>रु.<x-convert-to-unicode number="{{ $invoice->invoice_particulars_sum_total }}" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><b>अक्षरुपि</b>: <x-convert-to-word number="{{ $invoice->invoice_particulars_sum_total }}" /> मात्र</td>
                                        </tr>
                                        </tfoot>
                                    </table>


                            <div class="d-flex justify-content-between mt-4">
                                <div class="dashed">बुझाउनेको सहि</div>
                                <div class="dashed">बुझिलिनेको सहि</div>
                            </div>
                            <div class="text-center mt-2">
                                <p>तयार गर्ने: {{ $invoice->user->name }} | प्रिन्ट: {{$nepaliDate}} {{ get_nepali_number(now()->format('h:i:s A')) }}</p>
                            </div>
                        </div>

                        <hr class="dashed">

                        {{-- Office Copy --}}
                        <div>
                            {!! letterHead() !!}
                            <div class="text-center">
                                <h4 class="fw-bold mb-0 text-decoration-underline">नगदी रसिद</h4>
                                <p>(कार्यालय प्रति)</p>
                            </div>

                            <div class="info">
                                <p><strong>रसिद नं.:</strong> {{ $invoice->invoice_no }}</p>
                                <p><strong>सेवाग्राहीको नाम:</strong> {{ $invoice->name }}</p>
                                <p><strong>ठेगाना:</strong> {{ $invoice->address }}</p>
                                <p><strong>मिति:</strong> {{ get_nepali_number($invoice->payment_date) }}</p>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>बिषय</th>
                                    <th>परिणाम</th>
                                    <th>दर</th>
                                    <th>बक्यौता</th>
                                    <th>जम्मा</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoice->invoiceParticulars as $particular)
                                    <tr>
                                        <td>{{ $particular->revenue }}</td>
                                        <td><x-convert-to-unicode number="{{ $particular->quantity }}" /></td>
                                        <td>रु.<x-convert-to-unicode number="{{ $particular->rate }}" /></td>
                                        <td>रु.<x-convert-to-unicode number="{{ $particular->due_amount }}" /></td>
                                        <td>रु.<x-convert-to-unicode number="{{ $particular->grand_total_amount }}" /></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">जम्मा</th>
                                    <td>रु.<x-convert-to-unicode number="{{ $invoice->invoice_particulars_sum_total }}" /></td>
                                </tr>
                                <tr>
                                    <td colspan="5"><b>अक्षरुपि</b>: <x-convert-to-word number="{{ $invoice->invoice_particulars_sum_total }}" /> मात्र</td>
                                </tr>
                                </tfoot>
                            </table>

                            <div class="d-flex justify-content-between mt-4">
                                <div class="dashed">रकम बुझाउनेको सहि</div>
                                <div class="dashed">रकम बुझिलिनेको सहि</div>
                            </div>
                            <div class="text-center mt-2">
                                <p>तयार गर्ने: {{ $invoice->user->name }} | प्रिन्ट: {{$nepaliDate}} {{ get_nepali_number(now()->format('h:i:s A')) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
