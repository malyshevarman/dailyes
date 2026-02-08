<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// TODO добавить interface GalleryItem
class Video extends Model
{
    protected $fillable = ['link'];

    protected $appends = ['url', 'name'];

    public function gallery_items()
    {
        return $this->morphMany(GalleryItem::class, 'attachable');
    }

    public function getUrlAttribute()
    {
        parse_str(parse_url($this->link)['query'], $params);
        return 'https://img.youtube.com/vi/' . $params['v'] . '/hqdefault.jpg';
    }

    public function getNameAttribute()
    {
        return $this->link;
    }
}
