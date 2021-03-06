<?php

namespace Tsung\NovaMaster\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $table = 'master_documents';

    protected $fillable = [
        'document_type',
        'document_id',
        'file',
        'original_name',
        'original_size',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function documents()
    {
        return $this->morphTo('document');
    }

    public function getMimeTypeAttribute()
    {
        return mime_content_type(storage_path("app/public/") . $this->file);
    }

    public function getNoImageAttribute()
    {
        return "/nova-vendor/nova-master/no-image";
    }

}
