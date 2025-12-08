<?php

namespace App\Models\Settings;

use App\Models\Address\District;
use App\Models\Address\LocalBody;
use App\Models\Address\Province;
use App\Traits\EventObserveTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

final class OfficeSetting extends Model
{
    use EventObserveTrait;
    use SoftDeletes;


    protected $fillable = [

        'province_id',
        'district_id',
        'local_body_id',
        'ward_no',
        'fiscal_year_id',
    ];

    public function setLogoAttribute(mixed $value): void
    {
        if (! empty($value) && ! is_string($value)) {
            $this->attributes['logo'] = $value->store('office_setting/logo', 'public');
        }
    }

    public function setLogo1Attribute(mixed $value): void
    {
        if (! empty($value) && ! is_string($value)) {
            $this->attributes['logo1'] = $value->store('office_setting/logo', 'public');
        }
    }

    public function setLogo2Attribute(mixed $value): void
    {
        if (! empty($value) && ! is_string($value)) {
            $this->attributes['logo2'] = $value->store('office_setting/logo', 'public');
        }
    }

    public function setBackgroundImageAttribute(mixed $value): void
    {
        if (! empty($value) && ! is_string($value)) {
            $this->attributes['background_image'] = $value->store('office_setting/logo', 'public');
        }
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->attributes['logo'] ? Storage::disk('public')->url($this->attributes['logo']) : '';
    }

    public function getLogo1UrlAttribute(): string
    {
        return $this->attributes['logo1'] ? Storage::disk('public')->url($this->attributes['logo1']) : '';
    }

    public function getLogo2UrlAttribute(): string
    {
        return $this->attributes['logo2'] ? Storage::disk('public')->url($this->attributes['logo2']) : '';
    }

    public function getBackgroundImageUrlAttribute(): string
    {
        return $this->attributes['background_image'] ? Storage::disk('public')->url($this->attributes['background_image']) : '';
    }

    public function getAddressAttribute(): array
    {
        return [
            'province_id' => $this->attributes['province_id'] ?? null,
            'district_id' => $this->attributes['district_id'] ?? null,
            'local_body_id' => $this->attributes['local_body_id'] ?? null,
            'ward_no' => $this->attributes['ward_no'] ?? null,
        ];
    }

    public function getWardAttribute(): array
    {
        return [
            'ward_no' => $this->attributes['ward_no'],
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function localBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class);
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class);
    }
}
