<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;
use Storage;

class Article extends Model
{
    use Sluggable;
    use SoftDeletes;
    use Taggable;
    public $timestamps = true;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = ['title', 'slug', 'description', 'text', 'published'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $casts = [
        'published' => 'boolean'
    ];

    public function preview()
    {
        return $this->belongsTo(Download::class, 'preview_download_id');
    }

    public function background()
    {
        return $this->belongsTo(Download::class, 'background_download_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPreviewUrlAttribute()
    {
        if (empty($this->preview)) {
            return 'http://via.placeholder.com/285x300';
        }
        return Storage::url($this->preview->path);
    }
    
    public function getBackgroundUrlAttribute()
    {
        if (empty($this->background)) {
            return 'http://via.placeholder.com/1440x750';
        }
        return Storage::url($this->background->path);
    }

    public function getRelatedArticlesAttribute()
    {
        return self::where('id', '<>', $this->id)->whereHas('tags', function ($query) {
            $query->whereIn('name', $this->tags->pluck('name'));
        })->inRandomOrder()->limit(6)->get();
    }
}
