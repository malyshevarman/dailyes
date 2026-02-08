<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Tile extends Model
{
    protected $fillable = ['name', 'summary', 'start', 'end', 'title', 'description', 'text'];

    // public function selection()
    // {
    //     return $this->belongsTo(Selection::class);
    // }

    protected $dates = ['start', 'end'];

    protected $appends = ['type', 'items'];

    public function image()
    {
        return $this->belongsTo(Download::class, 'image_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categoriesTag()
    {
        return $this->belongsTo(CategoriesTag::class, 'categories_tag_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image) || !Storage::exists($this->image->path)) {
            return 'http://via.placeholder.com/2880x886';
        }
        return Storage::url($this->image->path);
    }

    public function companies()
    {
        return $this->morphedByMany(Company::class, 'model', 'tile_has_models');
    }

    public function events()
    {
        return $this->morphedByMany(Event::class, 'model', 'tile_has_models');
    }

    public function scopeActive($query)
    {
        return $query->whereDate('start', '<=', date('Y-m-d'))->where(function($q){
                $q->whereDate('end', '>=', date('Y-m-d'))
                ->orWhere('end', NULL);
            });
    }
    
    public function getTypeAttribute()
    {
        $events = $this->events;
        $companies = $this->companies;

        if ($events->count() <= 0 && $companies->count() <= 0) {
            return 'auto';
        }
        if ($events && $events->count() > 0) {
            if ($events->count() == 1) {
                return 'event-single';
            }
            return 'events';
        }
        if ($companies && $companies->count() > 0) {
            if ($companies->count() == 1) {
                return 'company-single';
            }
            return 'companies';
        }
        return null;
    }

    public function getItemsAttribute()
    {
        if ($this->type == 'event-single') {
            return $this->events()->active()->first();
        // } else if ($this->type == 'events') {
        //     return $this->events->implode('id', ',');
        } else if ($this->type == 'company-single') {
            return $this->companies()->active()->first();
        // } else if ($this->type == 'companies') {
        //     return $this->companies->implode('id', ',');
        } else if ($this->type == 'auto') {
            if (!is_null($this->categoriesTag)) {
                return $this->categoriesTag->events()->active()->get();
            } else {
                return collect([]);
            }
        }
        return null;
    }

    public function getUrlAttribute()
    {
        if ($this->type == 'event-single') {
            return route('frontend.event.show', $this->items);
        // } else if ($this->type == 'events') {
        //     return route('frontend.rating.event.show', $this);
        } else if ($this->type == 'company-single') {
            return route('frontend.company.show', $this->items);
        // } else if ($this->type == 'companies') {
        //     return route('frontend.rating.company.show', $this);
        } else if ($this->type == 'auto') {
            return route('frontend.rating.event.show', ['tag' => $this->categoriesTag]);
        }
        return '/';
    }

    // public function scopeActive($query)
    // {
    //     if ($this->type == 'event-single') {
    //         return $query->whereHas('events', function ($q) {
    //             $q->active();
    //         });
    //     } else if ($this->type == 'company-single') {
    //         return $query->whereHas('companies', function ($q) {
    //             $q->active();
    //         });
    //     } else {
    //         return $query;
    //     }
    // }
}
