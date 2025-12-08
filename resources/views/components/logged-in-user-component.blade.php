@if(auth()->check())
    <div class="user text-center p-2 pt-0">
        <img src="{{auth()->user()?->profile_photo_url ?? ''}}" alt="user-img" title="Mat Helme"
             class="rounded-circle avatar-sm mr-2" style="margin-right: 10px">
        <div class="mt-0">

            <h4 class="mb-0 fw-bold text-white d-flex flex-column text-left">
                <span style="text-align: left; font-size: 12px; font-weight: 200;">स्वागतम,</span>{{auth()->user()?->name}}</h4>
            <p class="text-white mb-0">{{auth()->user()?->email}}</p>
        </div>
    </div>
@endif
