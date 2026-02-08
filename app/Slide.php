<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Slide extends Model
{
    protected $fillable = ['name', 'summary', 'button', 'title', 'description', 'text'];

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
    // public function selection()
    // {
    //     return $this->belongsTo(Selection::class);
    // }

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

    // public function getTypeAttribute()
    // {
    //     if ($this->selection) {
    //         $events = $this->selection->events;
    //         $companies = $this->selection->companies;

    //         if ($events && $events->count() > 0) {
    //             if ($events->count() == 1) {
    //                 return 'event-single';
    //             }
    //             return 'events';
    //         }
    //         if ($companies && $companies->count() > 0) {
    //             if ($companies->count() == 1) {
    //                 return 'company-single';
    //             }
    //             return 'companies';
    //         }
    //     }
    //     return null;
    // }

    // public function getItemsAttribute()
    // {
    //     if ($this->type == 'event-single') {
    //         return $this->selection->events[0];
    //     } else if ($this->type == 'events') {
    //         return $this->selection->events->implode('id', ',');
    //     } else if ($this->type == 'company-single') {
    //         return $this->selection->companies[0];
    //     } else if ($this->type == 'companies') {
    //         return $this->selection->companies->implode('id', ',');
    //     }
    //     return null;
    // }

    public function getUrlAttribute()
    {
        // if ($this->type == 'event-single') {
        //     return route('frontend.event.show', $this->items);
        // } else if ($this->type == 'events') {
        //     return route('frontend.event.index', array_merge($this->selection->params, ['items' => $this->items, 'selection' => $this->selection]));
        // } else if ($this->type == 'company-single') {
        //     return route('frontend.company.show', $this->items);
        // } else if ($this->type == 'companies') {
        //     return route('frontend.company.index', array_merge($this->selection->params, ['items' => $this->items, 'selection' => $this->selection]));
        // } else if ($this->city == null) {
            return route('frontend.rating.company.show', ['tag' => $this->categoriesTag]);
        // }
        // return '/';
    }
}
