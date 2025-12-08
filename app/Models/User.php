<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Settings\LetterHead;
use App\Models\UserManagement\Role;
use App\Traits\EventObserveTrait;
use App\Traits\QueryFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

final class User extends Authenticatable
{
    use EventObserveTrait;
    use HasFactory;
    use Notifiable;
    use QueryFilterTrait;
    use SoftDeletes;


    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'role_id',
        'is_active',
        'password',
        'profile_photo_path',
        'designation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];



    final public function getProfilePhotoUrlAttribute(): string
    {
        return $this->attributes['profile_photo_path']
            ? Storage::disk('public')->url($this->attributes['profile_photo_path'])
            : asset('images/user_icon.jpg');
    }

    final public function setProfilePhotoPathAttribute(mixed $value): void
    {
        if (! empty($value) && ! is_string($value)) {
            $this->attributes['profile_photo_path'] = $value->store('user/profile/'.Str::slug($this->attributes['name'], '_'), 'public');
        }
    }


    public function scopeFilter(Builder $query, array $param = []): Builder
    {
        $this->filterByUserRole($query, $param);

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(__CLASS__);
    }


    public function users(): HasMany
    {
        return $this->hasMany(__CLASS__);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }



    public function getAvatarAttribute(): string
    {
        $name = $this->attributes['name'] ?? 'User';

        return new Avatar()->create($name)->toBase64();
    }

    public function letterHead(): MorphOne
    {
        return $this->morphOne(LetterHead::class, 'model');
    }
}
