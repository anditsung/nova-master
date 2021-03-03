<?php

namespace Tsung\NovaMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Unit extends Model
{
    use SaveToUpper;

    protected $table = 'master_units';

    protected $fillable = [
        'name',
        'abbr',
        'user_id',
        'is_active'
    ];

    protected $no_upper = [
    ];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
