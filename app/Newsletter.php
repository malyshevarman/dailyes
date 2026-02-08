<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['subject', 'text', 'data', 'is_active'];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean'
    ];

    protected $appends = [
    	'events',
    	'companies',
    	'city'
        // 'image_url', 
        // 'background_url', 
        // 'user_rating', 
        // 'user_recommendation', 
        // 'event_url',
        // 'status'
    ];

    public function getEventsAttribute() {
    	return \App\Event::whereIn('id', collect($this->data['events'])->pluck('id'))->get()->toArray();
    }

    public function getCompaniesAttribute() {
    	return \App\Company::whereIn('id', collect($this->data['companies'])->pluck('id'))->get()->toArray();
    }

    public function getCityAttribute() {
    	return \App\City::where('id', $this->data['city']['id'])->first()->toArray();
    }
}
