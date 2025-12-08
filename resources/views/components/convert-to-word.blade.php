@props([
    'id'=>uniqid(),
    'class'=>'',
    'number',
    'isCurrency'=>true
])

<span id="{{$id}}" class="{{$class}}"></span>
@once
    @push('scripts')
        <script src="{{asset('assets/backend/js/plugins/datepicker.min.js')}}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(document).ready(function () {
            const amount_in_words = NepaliFunctions.NumberToWordsUnicode({{$number}}, {{$isCurrency}})

            $('#{{$id}}').html(amount_in_words)
        });
    </script>
@endpush
