<?php

namespace App\Events\Recommendation;

use App\Recommendation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RecommendationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Recommendation $recommendation
     */
    public function __construct(Recommendation $recommendation)
    {
        $recommendationResult = $recommendation->recommendable->recommendation_result()->firstOrNew([

        ], [
            'positive' => 0,
            'negative' => 0,
        ]);

        if ($recommendation->bool) {
            $recommendationResult->positive = $recommendationResult->positive + 1;
        } else {
            $recommendationResult->negative = $recommendationResult->negative + 1;
        }

        $recommendationResult->save();
    }
}
