<?php

namespace App\Events\Rating;

use App\Rating;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RatingDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Rating $rating
     */
    public function __construct(Rating $rating)
    {
    	$oldData = $rating->getOriginal();
        $ratingResult = $rating->estimated->rating_results()->where('star', $oldData['star'])->first();
        $ratingResult->count = $ratingResult->count - 1;

        if ($ratingResult->count == 0) {
            $ratingResult->delete();
        } else {
            $ratingResult->save();
        }
    }
}
