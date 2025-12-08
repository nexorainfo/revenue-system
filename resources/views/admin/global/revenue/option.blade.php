<option {{$revenueCategory->id==old('revenue_category_id',($revenue->revenue_category_id ?? '')) ? 'selected' : ''}}
        value="{{$revenueCategory->id}}" {{$revenueCategory->revenueCategories->isNotEmpty() ? 'disabled' : ''}}>
    {{$revenueCategory->title}}
</option>
@if($revenueCategory->revenueCategories->isNotEmpty())
    @foreach($revenueCategory->revenueCategories as $childCategory)
        @include('admin.global.revenue.option' , ['revenueCategory' => $childCategory,'revenue' => $revenue ?? ''])
    @endforeach
@endif
