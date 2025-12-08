<div class="col-md-12">
    <fieldset>
        <legend>फारम</legend>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label for="form.revenue_category_id">राजस्वको वर्ग</label>
                <select
                    wire:model.live="form.revenue_category_id"
                    class="form-select @error('form.revenue_category_id') is-invalid @enderror"
                    id="form.revenue_category_id">
                    <option value="">--- छान्नुहोस् ---</option>
                    @foreach($revenueCategories as $revenue_category)
                        <x-revenue-category-options :revenueCategory="$revenue_category"/>
                    @endforeach
                </select>
                @error('form.revenue_category_id')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-2">
                <label for="form.revenue_id">राजस्वको शिर्षक</label>
                <select
                    wire:model="form.revenue_id"
                    wire:change="setRate()"
                    class="form-select @error('form.revenue_id') is-invalid @enderror"
                    id="form.revenue_id">
                    <option value="">--- छान्नुहोस् ---</option>
                    @foreach($revenues as $revenue)
                        <option
                            value="{{$revenue->id}}"
                        >
                            ({{$revenue->code_no}}) {{$revenue->title}}
                        </option>
                    @endforeach
                </select>
                @error('form.revenue_id')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-2">
                <label for="form.quantity">मात्रा</label>
                <input type="number" id="form.quantity"
                       class="form-control @error('form.quantity') is-invalid @enderror"
                       wire:model="form.quantity" value="1" step="0.01" min="0">
                @error('form.quantity')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-2">
                <label for="form.rate">दर</label>
                <input type="number" id="form.rate" class="form-control @error('form.rate') is-invalid @enderror"
                       wire:model="form.rate" value="0" step="0.01" min="0">
                @error('form.rate')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-2">
                <label for="form.remarks">कैफियत</label>
                <input type="text" id="form.remarks" class="form-control @error('form.remarks') is-invalid @enderror"
                       wire:model="form.remarks">
                @error('form.remarks')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
        </div>
        <button type="button" class="btn btn-primary btn-sm" wire:click.prevent="addDetail()">
            <i class="fa fa-save"></i>
        </button>
    </fieldset>
    <table class="table table-bordered table-sm mt-2">
        <thead>
        <tr>
            <th rowspan="2">क्र.सं</th>
            <th colspan="2">विवरण</th>
            <th rowspan="2">मात्रा</th>
            <th rowspan="2">दर</th>
            <th rowspan="2">जम्मा</th>
            <th rowspan="2">कैफियत</th>
            <th rowspan="2">#</th>
        </tr>
        <tr>
            <th>वर्ग</th>
            <th>राजस्वको शिर्षक</th>
        </tr>
        </thead>
        <tbody>
        @foreach($particulars as $index=>$detail)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                    <input type="hidden" name="particulars[{{$index}}][id]"
                           value="{{$detail['id'] ?? ''}}" required>
                    {{get_revenue_categories(revenueCategoryId: $detail['revenue_category_id'] )?->title }}
                    <input type="hidden" name="particulars[{{$index}}][revenue_category_id]"
                           value="{{$detail['revenue_category_id']}}">
                    @error('particulars.'.$index.'.revenue_category_id')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>
                <td>
                    ({{get_revenues(revenueId: $detail['revenue_id'] ?? null)?->code_no ?? ''}}
                    ) {{get_revenues(revenueId: $detail['revenue_id'] ?? null)?->title ?? ''}}
                    <input type="hidden" name="particulars[{{$index}}][revenue_id]"
                           value="{{$detail['revenue_id']}}">

                    <input type="hidden" name="particulars[{{$index}}][revenue]"
                           value="{{get_revenues(revenueId: $detail['revenue_id'] ?? null)->title ?? ''}}" required>

                    @error('particulars.'.$index.'.revenue_id')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    @error('particulars.'.$index.'.revenue')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>
                <td>
                    <input type="hidden" name="particulars[{{$index}}][quantity]"
                           value="{{$detail['quantity']}}" required>
                    {{$detail['quantity'] ?? 0}}
                    @error('particulars.'.$index.'.quantity')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>
                <td>
                    <input type="hidden" name="particulars[{{$index}}][rate]"
                           value="{{$detail['rate']}}" required>
                    {{$detail['rate'] ?? 0}}
                    @error('particulars.'.$index.'.rate')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>

                <td>
                    {{(($detail['rate'] ?? 0) * ($detail['quantity'] ?? 0))}}
                </td>
                <td>
                    <input type="hidden" name="particulars[{{$index}}][remarks]"
                           value="{{$detail['remarks']}}">
                    {{$detail['remarks'] ?? ''}}
                </td>
                <td class="d-flex">
                    <button type="button" class="btn btn-warning text-white mx-1 btn-sm"
                            wire:click.prevent="editDetail({{$index}})">
                        <i class="fa fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm"
                            wire:click.prevent="removeDetail({{$index}})">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
</div>
