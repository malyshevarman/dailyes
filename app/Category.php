<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Category extends Model
{
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'order', 'image_download_id', 'background_download_id'];

    // protected $appends = ['background_url'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, Company::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function tags()
    {
        return $this->hasMany(CategoriesTag::class);
    }
    // public function companies()
    // {
    //     return $this->belongsToMany(Company::class, 'company_has_categories');
    // }

    public function background()
    {
        return $this->belongsTo(Download::class, 'background_download_id');
    }

    public function image()
    {
        return $this->belongsTo(Download::class, 'image_download_id');
    }

    public function slide()
    {
        return $this->hasOne(Slide::class, 'category_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image) || !Storage::exists($this->image->path)) {
            return 'http://via.placeholder.com/510x600';
        }
        return Storage::url($this->image->path);
    }

    public function getBackgroundUrlAttribute()
    {
        if (empty($this->background) || !Storage::exists($this->background->path)) {
            return 'http://via.placeholder.com/1440x750';
        }
        return Storage::url($this->background->path);
    }

    public function tile()
    {
        return $this->hasOne(Tile::class, 'category_id', 'id');
    }

    // public function getSeoEventAttribute()
    // {
    //     return \App\Seo::where('seoable_id', $this->id)->where('seoable_type', 'App\EventCategory')->first();
    // }

    // public function getSeoCompanyAttribute()
    // {
    //     return \App\Seo::where('seoable_id', $this->id)->where('seoable_type', 'App\CompanyCategory')->first();
    // }
}
