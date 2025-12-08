@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">सेटिङ</a></li>
                            <li class="breadcrumb-item active">मेरो प्रोफाइल</li>
                        </ol>
                    </div>
                    <h4 class="page-title">मेरो प्रोफाइल</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{auth()->user()->profile_photo_url}}"
                             class="rounded-circle mb-1 avatar-lg img-thumbnail"
                             alt="profile-image">
                        <h4 class="mb-1">{{auth()->user()->name}} <i class="fa fa-check-circle text-success"></i></h4>
                        <div class="text-start mt-3">
                            <p class="text-muted mb-2 font-13"><strong>नाम :</strong>
                                <span class="ms-2">{{auth()->user()->name}}</span>
                            </p>
                            <p class="text-muted mb-2 font-13"><strong>भूमिका :</strong>
                                <span class="ms-2">{{auth()->user()->role->title ?? ''}}</span>
                            </p>
                            <p class="text-muted mb-2 font-13"><strong>इमेल :</strong>
                                <span class="ms-2">{{auth()->user()->email}}</span>
                            </p>
                            <p class="text-muted mb-2 font-13"><strong>सम्पर्क नं. :</strong>
                                <span class="ms-2">{{auth()->user()->phone}}</span>
                            </p>

                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col-->
            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill navtab-bg">
                            <li class="nav-item">
                                <a href="#timeline" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                    पासवर्ड परिवर्तन गर्नुहोस्
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    विवरण सम्पादन गर्नुहोस्
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="timeline">
                                <form action="{{route('admin.updatePassword')}}" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="current_password" class="form-label">पुरानो पासवर्ड *</label>
                                            <input
                                                type="password"
                                                name="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                id="current_password"
                                                placeholder="पुरानो पासवर्ड"
                                            />
                                            @error('current_password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="password" class="form-label">पासवर्ड *</label>
                                            <input
                                                type="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password"
                                                placeholder="पासवर्ड"
                                            />
                                            @error('password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="password_confirmation" class="form-label">पासवर्ड सुनिश्चित
                                                गर्नुहोस *</label>
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
                                    <button type="submit" class="btn btn-primary">
                                        पेश गर्नुहोस्
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane" id="settings">
                                <form action="{{route('admin.updateProfile')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
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
                                                    value="{{old('name', auth()->user()->name)}}"
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
                                                    value="{{old('email', auth()->user()->email)}}"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email"
                                                    placeholder="इमेल"
                                                />
                                                @error('email')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="phone" class="form-label">फोन नम्बर *</label>
                                                <input
                                                    type="text"
                                                    name="phone"
                                                    value="{{old('phone', auth()->user()->phone)}}"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    id="phone"
                                                    placeholder="फोन नम्बर"
                                                />
                                                @error('phone')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="profile_photo_path" class="form-label">फोटो </label>
                                                <input
                                                    type="file"
                                                    name="profile_photo_path"
                                                    class="form-control @error('profile_photo_path') is-invalid @enderror"
                                                    id="profile_photo_path"
                                                    accept="image/*"
                                                />
                                                @error('profile_photo_path')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary">
                                        पेश गर्नुहोस्
                                    </button>
                                </form>
                            </div>
                        </div> <!-- end tab-content -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
    </div>
@endsection
