@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.revenue.dashboard')}}">
                               <img class="icon me-1" src="{{asset('assets/backend/images/home.svg')}}" alt="document-icon">
                            गृहपृष्ठ
                            </a>
                        </li>
                        <li class="breadcrumb-item active">रसिद</li>
                    </ol>
                </div>
                <h4 class="page-title">रसिद</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">नयाँ रसिद थप्नुहोस्</h4>
                        <a href="{{route('admin.revenue.invoice.index')}}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-list"></i> रसिद सूची
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.revenue.invoice.update', $invoice)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <x-date-input-component
                                    nameNe="payment_date" labelNe="मिति *"
                                    nameEn="payment_date_en" labelEn="Date"
                                    editDateNe="{{$invoice->payment_date}}"
                                    editDateEn="{{$invoice->payment_date_en}}"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="tax_payer_id" class="form-label">करदाता</label>
                                <select
                                    name="tax_payer_id"
                                    class="form-select @error('tax_payer_id') is-invalid @enderror"
                                    id="tax_payer_id" data-toggle="select2" data-width="100%" required>
                                    <option value="">--- छान्नुहोस् ---</option>
                                    @foreach($taxPayers as $taxPayer)
                                        <option
                                            value="{{$taxPayer->id}}"
                                            {{old('tax_payer_id', $invoice->tax_payer_id) == $taxPayer->id ? 'selected' : ''}}
                                        >
                                            ({{$taxPayer->registration_no}}) {{$taxPayer->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tax_payer_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="fiscal_year_id" class="form-label">आर्थिक वर्ष</label>
                                <select
                                    name="fiscal_year_id"
                                    class="form-select @error('fiscal_year_id') is-invalid @enderror"
                                    id="fiscal_year_id" data-toggle="select2" data-width="100%" required>
                                    <option value="">--- छान्नुहोस् ---</option>
                                    @foreach($fiscalYears as $fiscalYear)
                                        <option
                                            value="{{$fiscalYear->id}}"
                                            {{old('fiscal_year_id', $invoice->fiscal_year_id) == $fiscalYear->id ? 'selected' : ''}}
                                        >
                                            {{$fiscalYear->title}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fiscal_year_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2 d-flex gap-1">
                                <div>
                                    <label for="payment_method" class="form-label">भुक्तानी बिधि</label>
                                    <select
                                        name="payment_method"
                                        class="form-select @error('payment_method') is-invalid @enderror"
                                        id="payment_method" data-toggle="select2" data-width="100%" required>
                                        <option
                                            value="Cash" {{old('payment_method', $invoice->payment_method) =='Cash' ? 'selected' : ''}}>
                                            नगद
                                        </option>
                                        <option
                                            value="Bank" {{old('payment_method', $invoice->payment_method)=='Bank' ? 'selected' : ''}}>
                                            बैंक
                                        </option>
                                    </select>
                                    @error('payment_method')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div id="showIfBank" class="d-none">
                                    <label for="reference_code" class="form-label">Reference Code</label>
                                    <input
                                        type="text"
                                        name="reference_code"
                                        value="{{old('reference_code', $invoice->reference_code)}}"
                                        class="form-control @error('reference_code') is-invalid @enderror"
                                        id="reference_code"
                                        placeholder="Reference Code"
                                        required
                                    />
                                    @error('reference_code')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="ward" class="form-label">वार्ड *</label>
                                <select
                                    name="ward"
                                    class="form-select @error('ward') is-invalid @enderror"
                                    id="ward" data-toggle="select2" data-width="100%">
                                    <option value="">--- छान्नुहोस् ---</option>

                                    @foreach(get_local_bodies(localBodyId: $officeSetting->local_body_id)->ward_no as $ward)
                                        <option
                                            value="{{$ward}}"
                                            {{old('ward', $invoice->ward) == $ward ? 'selected' : ''}}
                                        >
                                            {{$ward}}
                                        </option>

                                    @endforeach
                                </select>
                                @error('ward')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>

                            @livewire('revenue::invoice-form-livewire', ['formDetail'=>old('particulars',$invoice->invoiceParticulars)])

                            <div class="col-md-12 mb-2">
                                <label for="remarks" class="form-label">कैफियत *</label>
                                <textarea class="form-control @error('remarks') is_invalid @enderror" name="remarks"
                                          id="remarks" cols="30"
                                          rows="5">{{old('remarks', $invoice->remarks)}}</textarea>
                                @error('remarks')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#payment_method').change(function () {
                    let payment_method = $(this).val();
                    if (payment_method === 'Bank') {
                        $('#showIfBank').removeClass('d-none');
                    } else {
                        $('#showIfBank').addClass('d-none');
                    }
                });

            });
        </script>
    @endpush
@endsection
