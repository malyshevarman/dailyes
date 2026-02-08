<?php

namespace App\Events\RatingResult;

use App\RatingResult;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RatingResultSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param RatingResult $ratingResult
     */
    public function __construct(RatingResult $ratingResult)
    {
        $ratingResult->estimated->syncRating();
    }
}
