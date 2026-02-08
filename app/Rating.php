<?php

namespace App;

use App\Events\Rating\RatingCreated;
use App\Events\Rating\RatingUpdated;
use App\Events\Rating\RatingDeleted;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['star'];

    protected $dispatchesEvents = [
        'created' => RatingCreated::class,
        'updated' => RatingUpdated::class,
        'deleted' => RatingDeleted::class
    ];

    public function estimated()
    {
        return $this->morphTo();
    }
}
