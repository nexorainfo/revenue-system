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
                        <li class="breadcrumb-item">
                            <a href="">प्रयोगकर्ता व्यवस्थापन</a>
                        </li>
                        <li class="breadcrumb-item active">नयाँ भूमिका थप्नुहोस्</li>
                    </ol>
                </div>
                <h4 class="page-title">भूमिका</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">नयाँ भूमिका सूची</h4>
                        <a href="{{ route('admin.userManagement.role.index') }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-list"></i> भूमिका सूची
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.userManagement.role.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="title" class="form-label">भूमिका शीर्षक *</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror" id="title"
                                    placeholder="भूमिका शीर्षक" />
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="permissions" class="form-label">
                                    अनुमतिहरू *
                                </label>
                                <div class="row">
                                    @foreach ($permissionGroups as $key => $permissionGroup)
                                        <div class="col-md-6">
                                            <fieldset class="mb-2">
                                                <legend>{{ $key }}</legend>
                                                <div class="row">
                                                    @foreach ($permissionGroup as $permission)
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="permissions[]" value="{{ $permission['id'] }}"
                                                                    id="permission{{ $permission['id'] }}">
                                                                <label class="form-check-label"
                                                                    for="permission{{ $permission['id'] }}">{{ $permission['title'] }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endforeach
                                    @error('permissions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('permissions.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
