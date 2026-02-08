<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class EventLabel extends Model
{
    protected $fillable = ['name', 'icon_download_id'];

    protected $appends = ['icon_url'];

    public function icon()
    {
        return $this->belongsTo(Download::class, 'icon_download_id');
    }

    public function getIconUrlAttribute()
    {
        if (empty($this->icon)) {
            return 'http://via.placeholder.com/10x10';
        }
        return Storage::url($this->icon->path);
    }
}
