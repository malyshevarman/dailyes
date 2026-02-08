<?php

namespace App\Events\Rating;

use App\Rating;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RatingUpdated
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
        $oldratingResult = $rating->estimated->rating_results()->where('star', $oldData['star'])->first();
        
        $oldratingResult->count = $oldratingResult->count - 1;

        if ($oldratingResult->count == 0) {
            $oldratingResult->delete();
        } else {
            $oldratingResult->save();
        }
        
        $ratingResult = $rating->estimated->rating_results()->firstOrNew([
            'star' => $rating->star
        ], [
            'count' => 0
        ]);
        $ratingResult->count = $ratingResult->count + 1;

        $ratingResult->save();
    }
}
