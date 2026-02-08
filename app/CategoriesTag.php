<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Storage;

class CategoriesTag extends Model
{
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
	protected $fillable = ['name', 'slug', 'background_download_id', 'image_download_id', 'order'];

    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }

    public function events()
    {
    	return $this->belongsToMany(Event::class, 'event_has_categories_tags');
    }

    public function companies()
    {
    	return $this->belongsToMany(Company::class, 'company_has_categories_tags');
    }

    public function getEventSeoAttribute()
    {
        return \App\Seo::where('seoable_id', $this->id)->where('seoable_type', 'App\EventCategoriesTag')->first();
    }

    public function getCompanySeoAttribute()
    {
        return \App\Seo::where('seoable_id', $this->id)->where('seoable_type', 'App\CompanyCategoriesTag')->first();
    }
    // public function scopeActiveWithEvents($q) {
    //     return $this->whereHas('events', function($q) {
    //         $q->active();
    //     });
    // }

    // public function scopeActiveWithCompanies($q) {
    //     return $this->whereHas('companies', function($q) {
    //         $q->active();
    //     });
    // }

    public function background()
    {
        return $this->belongsTo(Download::class, 'background_download_id');
    }

    public function image()
    {
        return $this->belongsTo(Download::class, 'image_download_id');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image) || !Storage::exists($this->image->path)) {
            return 'http://via.placeholder.com/240x300';
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

    public function slide()
    {
        return $this->hasOne(Slide::class, 'categories_tag_id', 'id');
    }

    public function tile()
    {
        return $this->hasOne(Tile::class, 'categories_tag_id', 'id');
    }
}
