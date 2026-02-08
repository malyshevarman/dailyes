<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerPlace extends Model
{
    protected $fillable = ['name', 'key', 'width', 'height'];

    public function banners()
    {
        return $this->hasMany(Banner::class, 'place_id');
    }

    public function activeBanners()
    {
        return $this->hasMany(Banner::class, 'place_id')
        			->where('id', '>', 0)
        			->whereDate('start', '<=', date('Y-m-d'))
	                ->where(function($q){
	                	$q->whereDate('end', '>=', date('Y-m-d'))
	                	->orWhere('end', NULL);
	                });
    }
}
