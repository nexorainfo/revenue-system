<div class="row">
    <div class="col-md-6 mb-3">
        <label for="province_id" class="form-label">प्रदेश <span class="text-danger">*</span></label>
        <select wire:model.live="province_id" class="form-select @error('province_id') is-invalid @enderror" id="province_id" name="province_id">
            <option value="">प्रदेश छान्नुहोस्</option>
            @foreach ($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->province }}</option>
            @endforeach
        </select>
        @error('province_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="district_id" class="form-label">जिल्ला</label>
        <select wire:model.live="district_id" class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id">
            <option value="">जिल्ला छान्नुहोस्</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}">{{ $district->district }}</option>
            @endforeach
        </select>
        @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="local_body_id" class="form-label">पालिका</label>
        <select wire:model.live="local_body_id" class="form-select @error('local_body_id') is-invalid @enderror" id="local_body_id" name="local_body_id">
            <option value="">पालिका छान्नुहोस्</option>
            @foreach ($localBodies as $lb)
                <option value="{{ $lb->id }}">{{ $lb->local_body }}</option>
            @endforeach
        </select>
        @error('local_body_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="ward_no" class="form-label">वडा नं.</label>
        <select wire:model.live="ward_no" class="form-select @error('ward_no') is-invalid @enderror" id="ward_no" name="ward_no">
            <option value="">वडा छान्नुहोस्</option>
            @for ($i = 1; $i <= $wardCount; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        @error('ward_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
