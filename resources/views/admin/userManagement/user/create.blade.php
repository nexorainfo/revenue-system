@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">

                            गृहपृष्ठ
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.userManagement.user.index')}}">प्रयोगकर्ता व्यवस्थापन</a>
                        </li>
                        <li class="breadcrumb-item active">नयाँ प्रयोगकर्ता थप्नुहोस्</li>
                    </ol>
                </div>
                <h4 class="page-title">प्रयोगकर्ता</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">नयाँ प्रयोगकर्ता थप्नुहोस्</h4>
                        <a href="{{route('admin.userManagement.user.index')}}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-list"></i> प्रयोगकर्ता सूची
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.userManagement.user.store')}}" method="post">
                        @csrf
                        <fieldset class="border p-2 mb-2">
                            <legend class="font-16 text-info">
                                <strong>व्यक्तिगत विवरण </strong>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="name" class="form-label">नाम *</label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{old('name')}}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name"
                                        placeholder="नाम"
                                    />
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="form-label">इमेल *</label>
                                    <input
                                        type="text"
                                        name="email"
                                        value="{{old('email')}}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email"
                                        placeholder="इमेल"
                                    />
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="phone" class="form-label">फोन नम्बर *</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{old('phone')}}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        id="phone"
                                        placeholder="फोन नम्बर"
                                    />
                                    @error('phone')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="role_id" class="form-label">भूमिका *</label>
                                    <select name="role_id"
                                            class="form-select @error('role_id') is-invalid @enderror"
                                            id="role_id">
                                        <option value="">भूमिका छान्नुहोस्</option>
                                        @foreach($roles as $role)
                                            <option
                                                value="{{$role->id}}" {{$role->id==old('role_id') ? 'selected' : ''}}>
                                                {{$role->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="designation" class="form-label">पद</label>
                                    <input
                                        name="designation"
                                        value="{{old('designation')}}"
                                        class="form-control @error('designation') is-invalid @enderror"
                                        id="designation"
                                        placeholder="पद"
                                    />
                                    @error('designation')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                @if(!empty(officeSetting()->localbody))
                                <div class="col-md-3 mb-2">
                                    <label for="ward_no" class="form-label">वडा नं.</label>
                                    <select name="ward_no" id="ward_no" class="form-select" @if (!empty(auth()->user()->ward_no)) disabled @endif>
                                        <option value="">---वडा छान्नुहोस्---</option>
                                        @foreach (officeSetting()->localbody->ward_no as $ward)
                                            <option value="{{ $ward }}" @if(auth()->check() && auth()->user()->ward_no == $ward) selected @endif>
                                                {{ $ward }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('ward_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('ward_no.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </fieldset>
                        <fieldset class="border p-2 mb-2">
                            <legend class="font-16 text-info">
                                <strong> पासवर्ड</strong>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="password" class="form-label">पासवर्ड *</label>
                                    <input
                                        type="password"
                                        name="password"
                                        value="{{old('password')}}"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        placeholder="पासवर्ड"
                                    />
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="password_confirmation" class="form-label">पासवर्ड सुनिश्चित गर्नुहोस
                                        *</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        value="{{old('password_confirmation')}}"
                                        class="form-control"
                                        id="password_confirmation"
                                        placeholder="पासवर्ड सुनिश्चित गर्नुहोस"
                                    />
                                </div>
                            </div>
                        </fieldset>

                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
