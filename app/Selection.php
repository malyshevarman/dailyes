<?php

// namespace App;
// use Storage;
// use Illuminate\Database\Eloquent\Model;

// class Selection extends Model
// {
//     protected $fillable = ['name', 'params', 'background_downloads_id'];

//     protected $casts = [
//         'params' => 'array'
//     ];

//     public function companies()
//     {
//         return $this->morphedByMany(Company::class, 'model', 'selection_has_models');
//     }

//     public function events()
//     {
//         return $this->morphedByMany(Event::class, 'model', 'selection_has_models');
//     }

//     public function background()
//     {
//         return $this->belongsTo(Download::class, 'background_downloads_id');
//     }

//     public function tile()
//     {
//         return $this->hasOne(Tile::class);
//     }

//     public function slide()
//     {
//         return $this->hasOne(Slide::class);
//     }

//     public function getBackgroundUrlAttribute()
//     {
//         if (empty($this->background) || !Storage::exists($this->background->path)) {
//             return 'http://via.placeholder.com/1440x750';
//         }
//         return Storage::url($this->background->path);
//     }
// }
