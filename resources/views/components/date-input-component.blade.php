@props([
    'name_ne'=>'',
    'label_ne'=>'',
    'name_en'=>'',
    'label_en'=>'',
    'editDateNe'=> '',
    'editDateEn'=> '',
    'showEnglishDate'=>false,
    'range'=>false,
    'disableDate'=>false,
    'disableDays'=>false,
])
<div class="row">
    <div class="col-md-{{$showEnglishDate ? "6": "12"}}">
        <label for="{{$name_ne}}">{{$label_ne}}</label>
        <input type="text" name="{{$name_ne}}" class="form-control" id="{{$name_ne}}">
    </div>
    <div class=" {{$showEnglishDate ? "col-md-6": "d-none"}}">
        <label for="{{$name_en}}">{{$label_en}}</label>
        <input type="date" name="{{$name_en}}" class="form-control" id="{{$name_en}}"  pattern="\d{4}-\d{2}-\d{2}" readonly>
    </div>
    @once
        @push('scripts')
            <script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js" type="text/javascript"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Find the container no matter how it's named
                    const container = document.querySelector('.ndp-container')
                        || document.querySelector('[class*="ndp-container"]')
                        || document.querySelector('[class*="npd-container"]');

                    if (container) {
                        container.style.cssText += 'max-width:400px !important;';
                    }

                    // Also watch for dynamically added ones (common with CDN behavior)
                    const observer = new MutationObserver(function() {
                        const el = document.querySelector('.ndp-container, [class*="ndp-container"]');
                        if (el && getComputedStyle(el).maxWidth === '266px') {
                            el.style.cssText += 'max-width:400px !important;';
                        }
                    });

                    observer.observe(document.body, { childList: true, subtree: true });
                });
            </script>
        @endpush
    @endonce
    @push('scripts')
        <script type="text/javascript">

            $(document).ready(function () {
                let todayBsDate = NepaliFunctions.BS.GetCurrentDate('YYYY-MM-DD')
                let todayAdDate = NepaliFunctions.AD.GetCurrentDate('YYYY-MM-DD')
                const parsedNepaliDate = NepaliFunctions.ParseDate(todayBsDate).parsedDate
                const mainInput = document.getElementById("{{$name_ne}}");
                mainInput.NepaliDatePicker({
                    onSelect: function () {
                                let parsedDate = NepaliFunctions.ParseDate($("#{{$name_ne}}").val());
                                let englishDate = NepaliFunctions.BS2AD(parsedDate.parsedDate, "YYYY-MM-DD")
                                $("#{{$name_en}}").val(englishDate)
                    },
                    // "maxDate": {"year":parsedNepaliDate.year, "month":parsedNepaliDate.month,"day":parsedNepaliDate.day},
                    // "disableDaysAfter":1
                });


                $("#{{$name_en}}").change(function (){
                    let parsedDate = NepaliFunctions.ParseDate($("#{{$name_en}}").val());
                    let nepaliDate = NepaliFunctions.AD2BS(parsedDate.parsedDate, "YYYY-MM-DD")
                    $("#{{$name_ne}}").val(nepaliDate)
                })

                $('#{{$name_ne}}').val(todayBsDate)
                $('#{{$name_en}}').val(todayAdDate)

            });
        </script>
    @endpush
</div>
