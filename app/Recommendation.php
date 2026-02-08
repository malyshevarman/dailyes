<?php

namespace App;

use App\Events\Recommendation\RecommendationCreated;
use App\Events\Recommendation\RecommendationUpdated;
use App\Events\Recommendation\RecommendationDeleted;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = ['bool'];

    protected $dispatchesEvents = [
        'created' => RecommendationCreated::class,
        'updated' => RecommendationUpdated::class,
        'deleted' => RecommendationDeleted::class
    ];

    public function recommendable()
    {
        return $this->morphTo();
    }
}
