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
                        <li class="breadcrumb-item active">लेटर हेड</li>
                    </ol>
                </div>
                <h4 class="page-title">लेटर हेड </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">लेटर हेड </h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.systemSetting.letterHead.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="header" class="form-label">हेडर *</label>
                                <textarea name="header"
                                          id="header"
                                          cols="30" rows="10"
                                          class="form-control ckEditor @error('header') is-invalid @enderror">{{old('header',letterHead())}}</textarea>
                                @error('header')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="letter_head" class="form-label">लेटर हेड *</label>
                                <textarea name="letter_head"
                                          id="letter_head"
                                          cols="30" rows="10"
                                          class="form-control ckEditor @error('letter_head') is-invalid @enderror">{{old('letter_head',letterHead('letter_head'))}}</textarea>
                                @error('letter_head')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="header_en" class="form-label">लेटर हेड (अंग्रेजीमा)*</label>
                                <textarea name="header_en"
                                          id="header_en"
                                          cols="30" rows="10"
                                          class="form-control ckEditor @error('header_en') is-invalid @enderror">{{old('header_en',letterHeadEn())}}</textarea>
                                @error('header_en')
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
        <script src="{{asset('assets/backend/ckeditor/ckeditor.js')}}"></script>
        <script src="{{asset('assets/backend/ckeditor/editor.js')}}"></script>
    @endpush
@endsection

