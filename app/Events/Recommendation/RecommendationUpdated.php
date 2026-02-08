<?php

namespace App\Events\Recommendation;

use App\Recommendation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RecommendationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Recommendation $recommendation)
    {
        $recommendationResult = $recommendation->recommendable->recommendation_result()->first();

        $recommendations = Recommendation::where('recommendable_id', $recommendation->recommendable->id)->get();
        $pos = 0;
        $neg = 0;

        foreach ($recommendations as $key => $value) {
            if ($value->bool) {
                $pos = $pos + 1;
            } else {
                $neg = $neg + 1;
            }
        }
        // if ($recommendation->bool) {
            $recommendationResult->positive = $pos;
        // } else {
            $recommendationResult->negative = $neg;
        // }

        $recommendationResult->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
