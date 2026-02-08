<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

// TODO добавить interface GalleryItem
class Download extends Model
{
    protected $guarded = [];

    protected $appends = ['url', 'name'];

    public function getPathUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function gallery_items()
    {
        return $this->morphMany(GalleryItem::class, 'attachable');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function getNameAttribute()
    {
        return $this->original_name;
    }
}
