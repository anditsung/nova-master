<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'file',
        'original_name',
        'original_size',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->morphTo('document');
    }
}
