@props([
    'id'=>uniqid(),
    'number'
])
<span id="unicode{{$id}}"></span>
@push('scripts')
    @once
        @push('scripts')
            <script src="{{asset('assets/backend/js/plugins/datepicker.min.js')}}"></script>
        @endpush
    @endonce
    <script type="text/javascript">
        $(document).ready(function () {
            console.log(NepaliFunctions.ConvertToUnicode({{$number}}), {{$number}})
            $("#unicode{{$id}}").html(NepaliFunctions.ConvertToUnicode({{$number}}))
        });
    </script>
@endpush

