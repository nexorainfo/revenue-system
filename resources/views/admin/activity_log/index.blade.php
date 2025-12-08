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
                        <li class="breadcrumb-item active">प्रयोगकर्ता गतिविधिहरू</li>
                    </ol>
                </div>
                <h4 class="page-title">प्रयोगकर्ता गतिविधिहरू</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">प्रयोगकर्ता गतिविधिहरू</h4>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="list-unstyled timeline-sm">
                        @forelse($activityLogs as $activityLog)
                            <li class="timeline-sm-item">
                            <span class="timeline-sm-date">
                                <x-ad-to-bs id="-activity{{$loop->iteration}}"
                                            :ad-date="$activityLog->created_at->toDateString()"/>
                            </span>
                                <h5 class="mt-0 mb-1">{{$activityLog->user->name??''}}</h5>
                                <p>{{class_basename($activityLog->model_type)}} ({{$activityLog->activity_type}})</p>
                                <p class="text-muted mt-2">
                                    डिभाइस : {{$activityLog->agent}} <br>
                                    आईपी : {{$activityLog->ip}}</p>
                            </li>
                        @empty
                            <li>कुनै डाटा उपलब्ध छैन !!!</li>
                        @endforelse
                    </ul>
                    {{$activityLogs->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
