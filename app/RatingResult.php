<?php

namespace App;

use App\Events\RatingResult\RatingResultSaved;
use Illuminate\Database\Eloquent\Model;

class RatingResult extends Model
{
    protected $fillable = ['star', 'count'];

    protected $dispatchesEvents = [
        'saved' => RatingResultSaved::class,
        'deleted' =>  RatingResultSaved::class,
    ];

    public function estimated()
    {
        return $this->morphTo();
    }
}
