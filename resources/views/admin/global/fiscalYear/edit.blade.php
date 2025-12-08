
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
                            <a href="{{route('admin.dashboard')}}">सेटिङ</a>
                        </li>
                        <li class="breadcrumb-item active"> आर्थिक बर्ष सम्पादन गर्नुहोस्</li>
                    </ol>
                </div>
                <h4 class="page-title">आर्थिक बर्ष</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">आर्थिक बर्ष सम्पादन गर्नुहोस्</h4>
                        <a href="{{route('admin.generalSetting.fiscalYear.index')}}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-list"></i> आर्थिक बर्ष सूची
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.generalSetting.fiscalYear.update',$fiscalYear)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="col-md-4 mb-2">
                            <label for="title" class="form-label">आर्थिक बर्ष  *</label>
                            <input
                                type="text"
                                name="title"
                                value="{{old('title',$fiscalYear->title)}}"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                placeholder="आर्थिक बर्ष "
                            />
                            @error('title')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
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
