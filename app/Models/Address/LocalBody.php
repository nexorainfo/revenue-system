<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class LocalBody extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'district_id',
        'local_body',
        'local_body_en',
        'wards',
    ];

    protected $appends = [
      'ward_no'
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function getWardNoAttribute(): Collection
    {
        $ward_no = collect();
        for ($i = 1; $i <= $this->wards; $i++) {
            $ward_no->push($i);
        }

        return $ward_no;
    }
}
