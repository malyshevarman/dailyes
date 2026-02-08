<?php

namespace App;

use App\Events\RecommendationResult\RecommendationResultSaved;
use Illuminate\Database\Eloquent\Model;

class RecommendationResult extends Model
{
    protected $fillable = ['positive', 'negative'];

    protected $dispatchesEvents = [
        'saved' => RecommendationResultSaved::class
    ];

    public function recommendable()
    {
        return $this->morphTo();
    }
}
