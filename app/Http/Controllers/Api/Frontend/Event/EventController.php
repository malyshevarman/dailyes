<?php

namespace App\Http\Controllers\Api\Frontend\Event;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Recommendation;
class EventController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function feature(Request $request)
    {
        $validData = $this->validate($request, [
            'slug' => 'required|exists:events,slug'
        ]);

        $event = Event::where('slug', $validData['slug'])->firstOrFail();

        return $event->feature();
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function rating(Request $request, Event $event)
    {
        $validData = $this->validate($request, [
            'star' => 'required|numeric|between:1,5'
        ]);
        $rat = auth()->user()->ratings()->where('estimated_id', $event->id)->where('estimated_type', 'App\Event')->first();

        if (empty($rat)) {
            $rat = auth()->user()->ratings()->make([
                'star' => $validData['star']
            ]);
            return $event->ratings()->save($rat);
        } else {
            if ($rat->star === $validData['star']) {
                $rat->delete();
                return 'deleted';
            } else {
                $rat->star = $validData['star'];
                $rat->save();
                return $event->ratings()->save($rat);
            }
        }
        // return $event->ratings()->save($rating = auth()->user()->ratings()->make([
        //     'star' => $validData['star']
        // ]));
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function recommendation(Request $request, Event $event)
    {
        $validData = $this->validate($request, [
            'bool' => 'required|boolean'
        ]);
        $rec = auth()->user()->recommendations()->where('recommendable_id', $event->id)->where('recommendable_type', 'App\Event')->first();

        if (empty($rec)) {
            $rec = auth()->user()->recommendations()->make([
                'bool' => $validData['bool']
            ]);
            return $event->recommendations()->save($rec);
        } else {
            if ($rec->bool === $validData['bool']) {
                $rec->delete();
                return 'deleted';
            } else {
                $rec->bool = $validData['bool'];
                $rec->save();
                return $event->recommendations()->save($rec);
            }
        }
    }
}
