<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-end mb-0 d-flex justify-content-center align-items-center">
            <li class="d-none d-xl-block">
                <h4 class="text-light top-heading mb-0" id="fiscalyear-tour">
                    <span class="arthik-barsa-badge">
                        <i class="lnr lnr-calendar-full"></i>{{__("Fiscal Year")}} {{$officeSetting->fiscalYear?->title??''}}
                    </span>
                </h4>
            </li>
            <li class="dropdown d-none d-lg-inline-block">
                <div class="nav-link dropdown-toggle arrow-none waves-effect waves-light">
                    <button
                        class="btn btn-xs cacheButton"
                        id="cacheBtn"
                        type="button"
                        data="{{route('admin.cache-clear')}}">
                        <i class="fas fa-brush"></i>
                    </button>
                </div>
            </li>
            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light"
                   data-bs-toggle="dropdown"
                   href="#"
                   role="button"
                   aria-haspopup="false"
                   aria-expanded="false"
                   id="noti-tour">
                    <i @class(['ring-bell'=>count(auth()->user()?->unreadNotifications ?? [])>0,'fa', 'lnr lnr-alarm', 'noti-icon'])></i>
                    @if(count(auth()->user()?->unreadNotifications ?? [])>0)
                        <span class="badge bg-danger rounded-circle noti-icon-badge">
                        {{count(auth()->user()?->unreadNotifications ?? [])}}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-16 fw-semibold"> नोटिफिकेसन</h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{route('admin.notification.readAllNotification')}}"
                                   class="text-dark text-decoration-underline">
                                    <small>सबै खाली गर्नुहोस्</small>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="noti-scroll" data-simplebar>
                        @forelse (auth()->user()?->unreadNotifications ??[] as $notification)
                            <a href="{{ route('admin.notification.read',$notification) }}"
                               class="dropdown-item notify-item">
                                <div class="notify-icon bg-info">
                                    <i class="lnr lnr-alarm"></i>
                                </div>
                                <p class="notify-details">
                                    @switch(class_basename($notification->type))
                                        @case('ApplyMapNoticeNotification')
                                            घर-नक्सा पासमा नयाँ निबेदन/प्रतिबेदन प्राप्त
                                            @break
                                        @case('MapApplyNotification')
                                            घर-नक्सा पासमा नयाँ नक्सा प्राप्त
                                            @break
                                        @default
                                            {{__("New notification")}}
                                    @endswitch
                                    <small class="text-muted">{{$notification->created_at?->diffForHumans()}}</small>
                                </p>
                            </a>
                        @empty
                            <h4 class="text-center my-3">{{__("No data available!")}}</h4>
                        @endforelse
                    </div>
                    <a href="{{route('admin.notification')}}"
                       class="dropdown-item text-center text-primary notify-item notify-all">
                        सबै हेर्नुहोस्
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </li>

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                   data-bs-toggle="dropdown"
                   href="#"
                   role="button"
                   aria-haspopup="false"
                   aria-expanded="false" id="profile-tour">
                    <img src="{{auth()->user()?->profile_photo_url ?? ''}}" alt="user-image" class="rounded-circle"/>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown">

                    <a href="{{route('admin.profile')}}" class="dropdown-item notify-item">
                        <i class="fa fa-user"></i>
                        <span>{{__("Profile")}}</span>
                    </a>
                    <a href="{{route('admin.activityLog.index')}}" class="dropdown-item notify-item">
                        <i class="fa fa-tasks"></i>
                        <span>{{__("Activities")}}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item notify-item">
                            <i class="fa fa-sign-out-alt"></i>
                            <span>{{__("Logout")}}</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>


        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect ">
                    <i class="lnr lnr-menu"></i>
                </button>
            </li>
            <li class="d-none d-xl-block">
                <h3 class="top-heading text-white fw-bold">
                    {{config('app.name') ?? ''}}
                </h3>
            </li>
        </ul>
    </div>
</div>
