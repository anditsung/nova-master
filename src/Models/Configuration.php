<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuration extends Model
{
    protected $table = 'master_configurations';

    protected $fillable = [
        'name',
        'config',
        'user_id',
    ];

    public static function getConfig(string $configName)
    {
        return self::where('name', $configName)->first();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
