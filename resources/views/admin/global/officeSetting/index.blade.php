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
                            <a href="{{route('admin.systemSetting.officeSetting.index')}}">प्रणाली सेटिङ</a>
                        </li>
                        <li class="breadcrumb-item active">प्रणाली सेटिङ सम्पादन गर्नुहोस्</li>
                    </ol>
                </div>
                <h4 class="page-title">प्रणाली सेटिङ</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">प्रणाली सेटिङ</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.systemSetting.officeSetting.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="fiscal_year_id" class="form-label">चालु आ.व. </label>
                                <select
                                        name="fiscal_year_id"
                                        class="form-select @error('fiscal_year_id') is-invalid @enderror"
                                        id="fiscal_year_id">
                                    <option value="">आ.व. छान्नुहोस्</option>
                                    @foreach($fiscalYears as $fiscalYear)
                                        <option
                                                value="{{$fiscalYear->id}}" {{$officeSetting?->fiscal_year_id == $fiscalYear->id ? 'selected':''}}>
                                            {{$fiscalYear->title}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fiscal_year_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <fieldset class="mb-2">
                            <legend>ठेगाना सेटअप</legend>

                            @livewire('address',['address'=>$officeSetting?->address])
                        </fieldset>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{asset('assets/backend/ckeditor/ckeditor.js')}}"></script>
        <script src="{{asset('assets/backend/ckeditor/editor.js')}}"></script>
        @endpush

@endsection
