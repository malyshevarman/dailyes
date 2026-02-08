<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
	protected $table = 'seo';
	
	protected $fillable = ['title', 'h1', 'description', 'page_text'];
    /**
     * Get the parent imageable model (user or post).
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
