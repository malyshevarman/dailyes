<?php

namespace App\Http\Controllers\Api\Cabinet\Event;

use App\Company;
use App\Download;
use App\Event;
use App\GalleryItem;
use App\Http\Controllers\Controller;
use App\Notifications\Event\EventDelete;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Storage;

class EventController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $date = date("Y-m-d");
        $validData = $this->validate($request, [
            'company.id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'summary' => 'nullable|string',
            'image' => 'required|array',
            'image.id' => 'exists:downloads,id',
            'background' => 'required|array',
            'background.id' => 'exists:downloads,id',
            'start' => 'required|date_format:Y-m-d H:i:s|after_or_equal:'.$date,
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'about' => 'required|nullable|string',
            'gallery_items' => 'array',
            'addresses' => 'required|array',
            // 'categories' => 'required|array',
            // 'categories.*.id' => 'exists:categories,id',
            'tags' => 'required|array'
        ]);

        $event = Event::make($validData);
        // $event->active = false;
        $event->company()->associate(Company::find($validData['company']['id']));
        $event->image()->associate(Download::find($validData['image']['id']));
        $event->background()->associate(Download::find($validData['background']['id']));
        $event->save();

        $event->addresses()->sync(Arr::pluck($validData['addresses'], 'id'));
        // $event->categories()->sync(Arr::pluck($validData['categories'], 'id'));
        if (isset($validData['tags'])) {
            $event->tags()->sync(Arr::pluck($validData['tags'], 'id'));
        }
        // Галерея
        $galleryItemIds = Arr::pluck($validData['gallery_items'] ?? [], 'id');
        foreach ($galleryItemIds as $id) {
            $event->gallery_items()->save(GalleryItem::find($id));
        }

        return $event->load([
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
            // 'categories',
            'tags',
            // 'categories.tags',
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
        if ($event->user->id != \Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $event->load([
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
            // 'categories',
            'tags',
            // 'categories.tags',
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
        if ($event->user->id != \Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $date = date("Y-m-d");
        $validData = $this->validate($request, [
            // 'company.id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'summary' => 'nullable|string',
            'image' => 'required|array',
            'image.id' => 'exists:downloads,id',
            'background' => 'required|array',
            'background.id' => 'exists:downloads,id',
            'start' => 'required|date_format:Y-m-d H:i:s|after_or_equal:'.$date,
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'about' => 'required|nullable|string',
            'gallery_items' => 'array',
            'addresses' => 'required|array',
            // 'categories' => 'required|array',
            'published' => 'required|boolean',
            'active' => 'required|boolean',
            'rejected' => 'required|boolean',
            'tags' => 'required|array'
        ]);

        if ($validData['rejected']) {
            $validData['rejected'] = false;
        }
        $event->fill($validData);
        // $event->company()->associate(Company::find($validData['company']['id']));

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
        // $event->categories()->sync(Arr::pluck($validData['categories'], 'id'));
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
            // 'categories',
            'tags',
            // 'categories.tags',
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


        if ($event->user->id != \Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // $notifi = DB::table('notifications')->where('data->id', '=', $event->id)->delete();

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

        //уведомляем пользваотеля
        $validData['event'] = $event;
        $validData['user_name'] = Auth::user()->name;
        $event->user->notify(new EventDelete($event));

        return $result;
    }

    // функция производит поиск акций по базе по переданной строке
    // если строка является числом, то происходит точная выборка id
    // если строка, то поиск идет только по названию акции
    public function search(Request $request, $string)
    {
        $query = Event::whereHas('user', function ($query) {
            $query->where('id', \Auth::id());
        });

        if ($string) {
            $query->where(function ($query) use ($string) {
                $query
                    ->where('name', 'LIKE', '%' . $string . '%')
                    ->when($id = filter_var($string, FILTER_VALIDATE_INT), function ($query) use ($id) {
                        $query->orWhere('id', $id);
                    });
            });
        }

        $items = $query->get();

        return $items;
    }

    public function status(Request $request, $id)
    {
        $event = Event::find($id);



        if ($event->active) {
            $event->active = false;
            $notifi = DB::table('notifications')->where('data->id', '=', $id)->delete();
        } else {
            $event->active = true;
        }
        $event->save();
        return redirect()->route('cabinet.event.index');
    }

}
