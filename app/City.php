<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use DB;
use GoogleMaps;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = ['name', 'slug', 'lat', 'long', 'timezone'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // сортировка по удаленности
    public function scopeNear($query)
    {
        $ip_address = request()->getClientIp();
        $geoip = geoip($ip_address);

        return $query
            ->orderByRaw('SQRT((' . $geoip->lat . ' - cities.lat)*(' . $geoip->lat . ' - cities.lat)+(' . $geoip->lon . ' - cities.long)*(' . $geoip->lon . ' - cities.long))');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    // public function save(array $options = [])
    // {
    //     // Если при сохранении изменяется параметр 'lat' и 'long'
    //     if ($this->isDirty('lat') && $this->isDirty('long')) {
    //         // записываем таймзону из api google timezone
    //         $this->timezone = json_decode(resolve(GoogleMaps::class)->load('timezone')
    //             ->setParam([
    //                 'location' => [$this->lat, $this->long],
    //                 'timestamp' => -1
    //             ])
    //             ->get())->timeZoneId;
    //     }
    //     return parent::save($options);
    // }
}
