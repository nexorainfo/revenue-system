@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.revenue.dashboard')}}">

                            गृहपृष्ठ
                            </a>
                        </li>
                        <li class="breadcrumb-item active">राजस्वको शिर्षक</li>
                    </ol>
                </div>
                <h4 class="page-title">राजस्वको शिर्षक</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">नयाँ राजस्वको शिर्षक थप्नुहोस्</h4>
                        <a href="{{route('admin.revenue.setting.revenue.index')}}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-list"></i> राजस्वको शिर्षक सूची
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.revenue.setting.revenue.update', $revenue)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="revenue_category_id" class="form-label">मुख्य वर्ग</label>
                                <select
                                    name="revenue_category_id"
                                    class="form-select @error('revenue_category_id') is-invalid @enderror"
                                    id="revenue_category_id" data-toggle="select2" data-width="100%" required>
                                    <option value="">--- छान्नुहोस् ---</option>
                                    @foreach($revenueCategories as $revenueCategory)
                                        @include('revenue::admin.setting.revenue.option' , ['revenueCategory' => $revenueCategory, 'revenue' => $revenue ?? ''])
                                    @endforeach
                                </select>
                                @error('revenue_category_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="title" class="form-label">शिर्षक *</label>
                                <input
                                    type="text"
                                    name="title"
                                    value="{{old('title', $revenue->title)}}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    placeholder="शिर्षक"
                                    required
                                />
                                @error('title')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="code_no" class="form-label">कोड नं. *</label>
                                <input
                                    type="text"
                                    name="code_no"
                                    value="{{old('code_no', $revenue->code_no)}}"
                                    class="form-control @error('code_no') is-invalid @enderror"
                                    id="code_no"
                                    placeholder="कोड नं."
                                    required
                                />
                                @error('code_no')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="amount" class="form-label">रकम *</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="amount"
                                    value="{{old('amount', $revenue->amount)}}"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    id="amount"
                                    placeholder="रकम"
                                    required
                                />
                                @error('amount')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="description" class="form-label">विवरण *</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="5">{{old('description', $revenue->description)}}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="remarks" class="form-label">कैफियत *</label>
                                <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" id="remarks" cols="30" rows="5">{{old('remarks', $revenue->remarks)}}</textarea>
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
@endsection
