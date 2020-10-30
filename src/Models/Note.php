<?php

namespace Tsung\NovaMaster\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tsung\NovaUserManagement\Traits\SaveToUpper;

class Note extends Model
{
    use SaveToUpper;

    protected $table = 'master_notes';

    protected $no_upper = [
        'note_type'
    ];

    protected $fillable = [
        'note',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->morphTo('note');
    }
}
