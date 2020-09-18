<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Holiday extends Model
{
    use SaveToUpper;

    protected $no_upper = [
    ];

    protected $fillable = [
        'name',
        'date',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}