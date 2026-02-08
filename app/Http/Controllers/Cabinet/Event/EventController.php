<?php

namespace App\Http\Controllers\Cabinet\Event;

use App\Event;
use App\EventView;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO встроить фильтры
        $query = \Auth::user()->events();

        if ($request->input('completed')) {

            $query
                ->where(function ($query) {
                    $query->whereDate('end', '<', date('Y-m-d'));
                })
                ->orderBy('updated_at','desc');

        } else if ($request->input('moderation')) {

            $query
                  ->where('events.rejected', 0)
                  ->where('events.published', 0);

        } else if ($request->input('rejected')) {

            $query
                  ->where('events.rejected', 1)
                  ->where('events.published', 0);

        } else if ($request->input('waiting-for-action')) {
           $query
                  ->where('events.published', 1)
                  ->where('events.rejected', 0)
                  ->where('events.active', 0)
                  ->where(function ($query) {
                      $query->whereDate('end', '>=', date('Y-m-d'))
                            ->orWhere('end', NULL);
                  });
        } else {
            $query->where('events.active', 1)
                  ->where('events.rejected', 0)
                  ->where('events.published', 1)
                  ->where(function ($query) {
                        $query->whereDate('end', '>=', date('Y-m-d'))
                              ->orWhere('end', NULL);
                    });
        }

        if ($request->text) {
            $query->where('name', 'LIKE', '%' . $request->text . '%');
        }

        // отсортированные эвенты для показа в списке
        $events = (clone $query)->orderBy($request->input('orderBy.column') ?? 'updated_at', $request->input('orderBy.direction') ?? 'desc')
            ->with([
                'labels',
                // 'categories',
                'company',
                'company.category',
                'tags'
            ])
            ->paginate($request->input('pagination.per_page') ?? 8);

        return view('cabinet.event.index')
            ->withEvents($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cabinet.event.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('cabinet.event.edit')
            ->withEvent($event);
    }

    public function stat(Request $request, Event $event)
    {
        if ($request->input('month')) {
            $event = $event->load(['event_views' => function ($q) use ($request) {
                $q->whereDate('date', '>=', date("Y") . '-' . $request->input('month') . '-01')
                ->whereDate('date', '<=', date("Y") . '-' . $request->input('month') . '-31');
            }]);
            return $event;
        }

        if ($request->input('from')) {
            $event = $event->load(['event_views' => function ($q) use ($request) {
                $q->whereDate('date', '>=', $request->input('from'))
                ->whereDate('date', '<=', $request->input('to'));
            }]);
            return $event;
        }

        if ($request->input('from') == '' && $request->input('to') == '' && $request->ajax()) {
          return $event->load(['event_views']);
        }
        return view('cabinet.event.stat')
            ->withEvent($event->load(['views_weekly']));
    }

}
