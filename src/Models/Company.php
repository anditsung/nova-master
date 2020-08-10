<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Company extends Model
{
    use SaveToUpper;

    protected $no_upper = [
    ];

    protected $fillable = [
        'name',
        'abbr',
        'is_active',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address() : MorphOne
    {
        return $this->morphOne(Address::class, 'address');
    }

    public function phone() : MorphMany
    {
        return $this->morphMany(Phone::class, 'phone');
    }
}
