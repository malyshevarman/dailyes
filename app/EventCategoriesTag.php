<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategoriesTag extends Model
{
    protected $table = 'categories_tags';
    
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
