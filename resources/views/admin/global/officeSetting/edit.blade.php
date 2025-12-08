@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">
                               <img class="icon me-1" src="{{asset('assets/backend/images/home.svg')}}" alt="document-icon">
                            गृहपृष्ठ
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">कार्यालय सेटिङ</a>
                        </li>
                        <li class="breadcrumb-item active">कार्यालय सेटिङ सम्पादन गर्नुहोस्</li>
                    </ol>
                </div>
                <h4 class="page-title">कार्यालय सेटिङ</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">कार्यालय सेटिङ सम्पादन गर्नुहोस्</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.officeHeader.update',$officeHeader)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <fieldset class="border p-2 mb-2">
                            <legend class="font-16 text-info">
                                <strong>कार्यालय विवरण </strong>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="title" class="form-label">शिर्षक *</label>
                                    <input
                                        type="text"
                                        name="title"
                                        value="{{old('title',$officeHeader->title)}}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="title"
                                        placeholder="शिर्षक"
                                    />
                                    @error('title')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="title_en" class="form-label">शिर्षक(English) *</label>
                                    <input
                                        type="text"
                                        name="title_en"
                                        value="{{old('title_en',$officeHeader->title_en)}}"
                                        class="form-control @error('title_en') is-invalid @enderror"
                                        id="title_en"
                                        placeholder="शिर्षक(English)"
                                    />
                                    @error('title_en')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="font_color" class="form-label"> फन्ट रङ</label>
                                    <input
                                        type="color"
                                        name="font_color"
                                        value="{{old('name',$officeHeader->font_color)}}"
                                        class="form-control @error('font_color') is-invalid @enderror"
                                        id="font_color"
                                        placeholder="फन्ट रङ"
                                    />
                                    @error('font_color')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="font_size" class="form-label">फन्ट साइज </label>
                                    <input
                                        type="text"
                                        name="font_size"
                                        value="{{old('font_size',$officeHeader->font_size)}}"
                                        class="form-control @error('font_size') is-invalid @enderror"
                                        id="font_size"
                                        placeholder="फन्ट साइज"
                                    />
                                    @error('font_size')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="card_font" class="form-label">कार्ड फन्ट साइज </label>
                                    <input
                                        type="text"
                                        name="card_font"
                                        value="{{old('card_font',$officeHeader->card_font)}}"
                                        class="form-control @error('card_font') is-invalid @enderror"
                                        id="card_font"
                                        placeholder="कार्ड फन्ट साइज"
                                    />
                                    @error('card_font')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="font" class="form-label">फन्ट </label>
                                    <input
                                        type="text"
                                        name="font"
                                        value="{{old('font',$officeHeader->font)}}"
                                        class="form-control @error('font') is-invalid @enderror"
                                        id="font"
                                        placeholder="फन्ट"
                                    />
                                    @error('font')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="position" class="form-label">स्थान </label>
                                    <input
                                        type="number"
                                        name="position"
                                        value="{{old('position',$officeHeader->position)}}"
                                        class="form-control @error('position') is-invalid @enderror"
                                        id="position"
                                        placeholder="स्थान"
                                    />
                                    @error('position')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
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
