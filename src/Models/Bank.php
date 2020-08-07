<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'account',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function banks()
    {
        return $this->morphTo('bank');
    }
}
