<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['address', 'phone', 'phone2', 'work', 'mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun', 'site', 'lat', 'long'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_has_addresses');
    }

    // https://stackoverflow.com/questions/37876166/haversine-distance-calculation-between-two-points-in-laravel
    public function scopeIsWithinMaxDistance($query, $location, $radius = 25)
    {
        $haversine = "(6371 * acos(cos(radians($location->lat)) 
                     * cos(radians(addresses.lat)) 
                     * cos(radians(addresses.long) 
                     - radians($location->lng)) 
                     + sin(radians($location->lat)) 
                     * sin(radians(addresses.lat))))";

        return $query
//            ->select()//pick the columns you want here.
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$radius]);
    }

    public function getAddressAttribute($value)
    {
        $v = explode(',', $value);
        return str_replace($v[0] . ', ','',$value);
    }

    public function setAddressAttribute($value)
    {
        if (isset($this->city)) {
            $value = $this->city->name . ', ' . $value;
            $this->attributes['address'] = $value;
        } else {
            $this->attributes['address'] = $value;
        }
    }

}
