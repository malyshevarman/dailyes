<?php

namespace App\Events\RecommendationResult;

use App\RecommendationResult;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RecommendationResultSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param RecommendationResult $recommendationResult
     */
    public function __construct(RecommendationResult $recommendationResult)
    {
        $recommendationResult->recommendable->syncRecommendation();
    }
}
