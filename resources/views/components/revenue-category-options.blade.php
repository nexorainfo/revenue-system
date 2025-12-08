@props([
    'revenue' => null,
    'revenueCategory' => [],
    'level' => 0
])

<option
    value="{{ $revenueCategory->id }}"
    {{ $revenueCategory->id == old('revenue_category_id', ($revenue->revenue_category_id ?? '')) ? 'selected' : '' }}
    {{ $revenueCategory->revenueCategories->isNotEmpty() ? 'disabled' : '' }}
>
    {{ str_repeat('-- ', $level) . $revenueCategory->title }}
</option>

@if ($revenueCategory->revenueCategories->isNotEmpty())
    @foreach ($revenueCategory->revenueCategories as $childCategory)
        <x-revenue-category-options
            :revenue="$revenue"
            :revenueCategory="$childCategory"
            :level="$level + 1"
        />
    @endforeach
@endif
