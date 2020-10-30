<?php

namespace Tsung\NovaMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Unit extends Model
{
    use SaveToUpper;

    protected $table = 'master_units';

    protected $no_upper = [
    ];
}
