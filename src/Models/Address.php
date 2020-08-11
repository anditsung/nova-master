<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Address extends Model
{
    use SaveToUpper;

    protected $no_upper = [
        'address_type'
    ];

    protected $fillable = [
        'name',
        'address',
        'address_type',
        'address_id',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->morphTo('address');
    }
}
