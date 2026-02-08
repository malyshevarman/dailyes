<?php

namespace App\Http\Controllers\Api\Backend\Event;

use App\Company;
use App\Download;
use App\Event;
use App\GalleryItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Event::query()->with('company');

        if (!empty($request->search['text'])) {
            $query->where('name', 'LIKE', '%' . $request->search['text'] . '%');
        }

        if (!empty($request->search['city'])) {
            $city_id = $request->search['city'];
            if ($city_id !== 0) {
                $query->whereHas('addresses', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                });
            }
        }

        // if (!empty($request->status)) {
        //     switch ($request->status) {
        //         case 'active':
        //             $query->where('active', 1)
        //                 ->where('rejected', 0)
        //                 ->where('published', 1)
        //                 ->where('end', '>',date('Y-m-d'));
        //             break;
        //         case 'rejected':
        //             $query->where('rejected', 1)
        //                 ->where('active', 0)
        //                 ->where('published', 0);
        //             break;
        //         case 'unpublished':
        //             $query->where('published', 0)
        //                 ->where('rejected', 0)
        //                 ->where('active', 0);
        //             break;
        //         case 'closed':
        //             $query->where('active', 1)
        //                 ->where('rejected', 0)
        //                 ->where('published', 1)
        //             ->where('end', '<=',date('Y-m-d'));

        //             break;
        //     }
        // }

        if (!empty($request->status)) {
            switch ($request->status) {
                case 'moderation':
                    $query
                    //  ->where('active', 1)
                        ->where('rejected', 0)
                        ->where('published', 0);
                    break;
                case 'rejected':
                    $query->where('rejected', 1)
                        // ->where('active', 0)
                        ->where('published', 0);
                    break;
                case 'published':
                    $query->where('published', 1)
                        ->where('rejected', 0)
                        ->where('active', 1);
                    break;
                case 'disabled':
                    $query->where('active', 0);
                    break;
                 case 'completed':
                    $query
                        // ->where('active', 1)
                        // ->where('rejected', 0)
                        // ->where('published', 1)
                    ->where('end', '<=',date('Y-m-d'));

                    break;
            }
        }

        $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validData = $this->validate($request, [
            'company.id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'slug' => 'nullable|string|unique:events,slug',
            'summary' => 'nullable|string',
            'published' => 'required|boolean',
            'rejected' => 'required|boolean',
            'active' => 'required|boolean',
            'message' => 'nullable|string',
            'image.id' => 'required|exists:downloads,id',
            'background.id' => 'required|exists:downloads,id',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'about' => 'nullable|string',
            'gallery_items' => 'array',
            'addresses' => 'array',
            // 'category' => 'required|array',
            // 'category.*.id' => 'required|exists:categories,id',
            'labels.*.id' => 'nullable|exists:event_labels,id',
            'favorite' => 'required|boolean',
            'tags' => 'array'
        ]);

        $event = Event::make($validData);
        $event->company()->associate(Company::find($validData['company']['id']));
        $event->image()->associate(Download::find($validData['image']['id']));
        $event->background()->associate(Download::find($validData['background']['id']));
        $event->save();

        $event->addresses()->attach(Arr::pluck($validData['addresses'], 'id'));
        // $event->category()->attach(Arr::pluck($validData['category'], 'id'));
        $event->labels()->attach(Arr::pluck($validData['labels'] ?? [], 'id'));
        if (isset($validData['tags'])) {
            $event->tags()->sync(Arr::pluck($validData['tags'], 'id'));
        }
        // Галерея
        $galleryItemIds = Arr::pluck($validData['gallery_items'] ?? [], 'id');
        foreach ($galleryItemIds as $id) {
            $event->gallery_items()->save(GalleryItem::find($id));
        }

        return $event->load([
            'tags',
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'company',
            'company.category',
            'company.category.tags',
            'company.addresses',
            // 'category',
            // 'category.tags',
            'company.tags',
            'labels'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return $event->load([
            'tags',
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'company',
            'company.addresses' => function($query)
            {
                $query->select(array('addresses.*'))->join('cities', 'addresses.city_id', '=', 'cities.id')->orderBy('cities.name');
            },
            'company.addresses.city',
            'company.category',
            'company.category.tags',
            'company.tags',
            // 'category',
            // 'category.tags',
            'labels',
            'changes_log' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'changes_flags'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Event $event
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Event $event)
    {
        $validData = $this->validate($request, [
            'company.id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'slug' => 'required|string|unique:events,slug,' . $request->id,
            'summary' => 'nullable|string',
            'published' => 'required|boolean',
            'rejected' => 'required|boolean',
            'active' => 'required|boolean',
            'message' => 'nullable|string',
            'image.id' => 'required|exists:downloads,id',
            'background.id' => 'required|exists:downloads,id',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'about' => 'nullable|string',
            'gallery_items' => 'array',
            'addresses' => 'array',
            // 'category' => 'required|array',
            // 'category.*.id' => 'required|exists:categories,id',
            'labels.*.id' => 'nullable|exists:event_labels,id',
            'favorite' => 'required|boolean',
            'tags' => 'array'
        ]);

        $event->fill($validData);
        $event->company()->associate(Company::find($validData['company']['id']));

        if ($event->image->id !== $validData['image']['id']) {
            Storage::disk('public')->delete($event->image->path);
            $image = Download::find($event->image->id);
        }
        if ($event->background->id !== $validData['background']['id']) {
            Storage::disk('public')->delete($event->background->path);
            $background = Download::find($event->background->id);
        }
        
        $event->image()->associate(Download::find($validData['image']['id']));
        $event->background()->associate(Download::find($validData['background']['id']));
        $event->addresses()->sync(Arr::pluck($validData['addresses'], 'id'));
        // $event->category()->sync(Arr::pluck($validData['category'], 'id'));
        $event->labels()->sync(Arr::pluck($validData['labels'] ?? [], 'id'));
        if (isset($validData['tags'])) {
            $event->tags()->sync(Arr::pluck($validData['tags'], 'id'));
        }
        $event->save();
        isset($image) ?? $image->delete();
        isset($background) ?? $background->delete();
        // Обновление галереи
        $galleryItemIds = Arr::pluck($validData['gallery_items'] ?? [], 'id');
        GalleryItem::destroy($event->gallery_items->pluck('id')->diff($galleryItemIds));
        foreach ($galleryItemIds as $id) {
            // TODO на данный момент если существующее изображение изменится, в базе оно не обновится
            $event->gallery_items()->save(GalleryItem::find($id));
        }

        return $event->load([
            'tags',
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'company',
            'company.addresses',
            'company.category',
            'company.category.tags',
            'company.tags',
            // 'category',
            // 'category.tags',
            'labels',
            'changes_log' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'changes_flags'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return int
     */
    public function destroy(Event $event)
    {
        //ПЕРЕНЕСТИ!!!
        foreach ($event->comments as $key => $comment) {
            $comment->delete();
            foreach ($comment->answers as $key => $answer) {
                $answer->delete();
            }
        }
        foreach ($event->questions as $key => $question) {
            $question->delete();
            // foreach ($question->answers as $key => $answer) {
            //     $answer->delete();
            // }
        }
        foreach ($event->user->notifications as $key => $notification) {
            if (isset($notification->data['type']) && isset($notification->data['id'])) {
                if ($notification->data['type'] == Event::class && $notification->data['id'] == $event->id) {
                    $notification->delete();
                }
            }
        }

        $event->reports()->delete();
        $event->gallery_items()->delete();
        $image = $event->image();
        $background = $event->background();
        $event->ratings()->delete();
        $event->rating_results()->delete();
        $event->recommendations()->delete();
        $event->recommendation_result()->delete();
        $event->addresses()->detach();

        $result = Event::destroy($event->id);
        $image->delete();
        $background->delete();

        return $result;
    }

    public function count()
    {
        return Event::count();
    }

    // функция производит поиск акции по базе по переданной строке
    // если строка является числом, то происходит точная выборка id
    // если строка, то поиск идет только по названию акции
    public function search(Request $request, $string)
    {
        $query = Event::query();

        if ($string) {
            $query
                ->where('name', 'LIKE', '%' . $string . '%')
                ->when($id = filter_var($string, FILTER_VALIDATE_INT), function ($query) use ($id) {
                    $query->orWhere('id', $id);
                })
                ->active();
        }

        $items = $query->get();

        return $items;
    }
}
