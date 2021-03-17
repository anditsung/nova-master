<?php

namespace Tsung\NovaMaster\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tsung\NovaHumanResource\Models\Employee;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Company extends Model
{
    use SaveToUpper;

    protected $table = 'master_companies';

    protected $no_upper = [
        'wl_id',
        'wl_reporter_id',
    ];

    protected $fillable = [
        'name',
        'abbr',
        'wl_id',
        'wl_reporter_id',
        'is_active',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function address() : MorphOne
    {
        return $this->morphOne(Address::class, 'address', 'address_type', 'address_id');
    }

    public function phones() : MorphMany
    {
        return $this->morphMany(Phone::class, 'phones', 'phone_type', 'phone_id');
    }

    public function employees() : HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
