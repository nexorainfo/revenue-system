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
                        <li class="breadcrumb-item active">वर्ग</li>
                    </ol>
                </div>
                <h4 class="page-title">वर्ग</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-0">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">नयाँ वर्ग थप्नुहोस्</h4>
                        <a href="{{ route('admin.generalSetting.revenue-category.index') }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-list"></i> वर्ग सूची
                        </a>
                    </div>
                </div>
                <div class="card-body px-0">
                    <form action="{{ route('admin.generalSetting.revenue-category.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="revenue_category_id" class="form-label">मुख्य वर्ग</label>
                                <select name="revenue_category_id"
                                    class="form-control @error('revenue_category_id') is-invalid @enderror"
                                    id="revenue_category_id" data-toggle="select2" data-width="100%">
                                    <option value="">--- छान्नुहोस् ---</option>
                                    @foreach ($revenueCategories as $revenueCategory)
                                        <option {{ $revenueCategory->id == old('revenue_category_id') ? 'selected' : '' }}
                                            value="{{ $revenueCategory->id }}">
                                            {{ $revenueCategory->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('revenue_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="title" class="form-label">शिर्षक *</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror" id="title"
                                    placeholder="शिर्षक" required />
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
