@props([
    'targetElement'=>'',
    'btnLabel'=>'',
    'btnClass'=>'',
    'title'=>'',
    'headerRequired'=>'',
    'headerType'=>''
    ])
<div>
    <button class="btn btn-light {{ $btnClass }}" onclick="printForm()" style="height:30px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer"
             viewBox="0 0 16 16">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
            <path
                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
        </svg>{{ $btnLabel }}
    </button>
    <div class="d-none header-content">
        @if ($headerRequired)
            {!! letterHead($headerType) !!}
        @endif
    </div>
    <script>
        function printForm() {
            printJS({
                printable: '{{ $targetElement }}',
                type: 'html',
                documentTitle: '{{ $title }}',
                showModal: true,
                header: $('.header-content').html(),
                targetStyles: ['*'],
                css: ['{{ asset('assets/backend/css/bootstrap.min.css') }}',
                    '{{ asset('assets/backend/css/app.min.css') }}'
                ],
                scanStyles: false,
                honorMarginPadding: false,
                modalMessage: 'तपाईंको कागजात छाप्नको लागि तयार हुँदैछ।'
            });
        }
    </script>
</div>
