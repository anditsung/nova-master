<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Bank extends Model
{

    use SaveToUpper;

    protected $table = 'master_banks';

    protected $no_upper = [
        'bank_type'
    ];

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
