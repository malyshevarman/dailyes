<?php

namespace App\Http\Controllers\Api\Backend\Company;

use App\Address;
use App\City;
use App\Company;
use App\CategoriesTag;
use App\Download;
use App\GalleryItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Company::query();

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
            'name' => 'required|string|unique:companies,name',
            'url' => 'nullable|url',
            'summary' => 'nullable|string',
            'about' => 'required|nullable|string',
            // 'image' => 'required|array',
            'image.id' => 'required|exists:downloads,id',
            // 'background' => 'required|array',
            'background.id' => 'required|exists:downloads,id',
            'gallery_items' => 'array',
            // 'categories' => 'required|array|exists:categories,id',
            'category' => 'required',
            // 'categories.*.id' => 'exists:categories,id',
            'addresses' => 'required|array',
            // 'addresses.*.city.name' => 'required|string',
            // 'addresses.*.city.lat' => 'required|numeric',
            // 'addresses.*.city.long' => 'required|numeric',
            // 'addresses.*.address' => 'required|string',
            // 'addresses.*.phone' => 'nullable|string',
            // 'addresses.*.phone2' => 'nullable|string',
            // 'addresses.*.work' => 'nullable|string',
            // 'addresses.*.lat' => 'required|numeric',
            // 'addresses.*.long' => 'required|numeric',
            // 'addresses.*.site' => 'string',
            'verification_email' => 'nullable|email|unique:companies,verification_email',
            'active' => 'required|boolean',
            'published' => 'required|boolean',
            'tags' => 'array'
        ]);

        $company = Company::make($validData);
        // if ($request->published) {
            // $company->published = true;
        // }
        $company->user_id = auth()->id();
        $company->verify_token = Str::random(60);
        $company->image()->associate(Download::find($validData['image']['id']));
        $company->background()->associate(Download::find($validData['background']['id']));
        $company->category()->associate($validData['category']['id']);
        $company->save();

        $company->addresses()->saveMany(array_reduce(
            $request->addresses,
            function ($res, $a) {
                // Вытаскиваем по названию город либо создаем новый
                $city = City::firstOrCreate([
                    'name' => $a['city']['name']
                ], [
                    'lat' => $a['city']['lat'],
                    'long' => $a['city']['long']
                ]);
                if ($a['work'] == false) {
                    
                    $address = Address::make([
                        'address' => $a['address'],
                        'phone' => $a['phone'] ?? null,
                        'phone2' => $a['phone2'] ?? null,
                        'work' => null,
                        'mon' => $a['mon'] ?? null,
                        'tues' => $a['tues'] ?? null,
                        'wed' => $a['wed'] ?? null,
                        'thurs' => $a['thurs'] ?? null,
                        'fri' => $a['fri'] ?? null,
                        'sat' => $a['sat'] ?? null,
                        'sun' => $a['sun'] ?? null,
                        'site' => $a['site'] ?? null,
                        'lat' => $a['lat'],
                        'long' => $a['long']
                    ]);
                } else {
                    $address = Address::make([
                        'address' => $a['address'],
                        'phone' => $a['phone'] ?? null,
                        'phone2' => $a['phone2'] ?? null,
                        'work' => 'Круглосуточно',
                        'mon' => '00:00-00:00',
                        'tues' => '00:00-00:00',
                        'wed' => '00:00-00:00',
                        'thurs' => '00:00-00:00',
                        'fri' => '00:00-00:00',
                        'sat' => '00:00-00:00',
                        'sun' => '00:00-00:00',
                        'site' => $a['site'] ?? null,
                        'lat' => $a['lat'],
                        'long' => $a['long']
                    ]);
                }
                $address->city()->associate($city);

                array_push($res, $address);
                return $res;
            },
            []
        ));

        if (isset($validData['tags'])) {
            $company->tags()->sync(Arr::pluck($validData['tags'], 'id'));
        }

        // Галерея
        $galleryItemIds = Arr::pluck($validData['gallery_items'] ?? [], 'id');
        foreach ($galleryItemIds as $id) {
            $company->gallery_items()->save(GalleryItem::find($id));
        }

        return $company->load([
            'tags',
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'category',
            'category.tags',
            'changes_log' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'changes_flags'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return $company->load([
            'tags',
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses' => function($query)
            {
                $query->select(array('addresses.*'))->join('cities', 'addresses.city_id', '=', 'cities.id')->orderBy('cities.name');
            },
            'addresses.city',
            'category',
            'category.tags',
            'changes_log' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'changes_flags'
        ])->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'name' => 'required|string|unique:companies,name,' . $request->id,
            'slug' => 'nullable|string|unique:companies,slug,' . $request->id,
            'url' => 'nullable|url',
            'summary' => 'nullable|string',
            'about' => 'required|nullable|string',
            'published' => 'required|boolean',
            'rejected' => 'required|boolean',
            'active' => 'required|boolean',
            'message' => 'nullable|string',
            // 'image' => 'required|array',
            'image.id' => 'required|exists:downloads,id',
            // 'background' => 'required|array',
            'background.id' => 'required|exists:downloads,id',
            'gallery_items' => 'array',
            'category' => 'required',
            // 'categories.*.id' => 'required|exists:categories,id',
            'verification_email' => 'nullable|email|unique:companies,verification_email,'.$company->id,
            'addresses' => 'required|array',
            'tags' => 'array'
        ]);

        $company->fill($validData);
        if (is_null($company->verify_token)) {
            $company->verify_token = Str::random(60);
        }

        if ($company->image->id !== $validData['image']['id']) {
            Storage::disk('public')->delete($company->image->path);
            $image = Download::find($company->image->id);
        }
        if ($company->background->id !== $validData['background']['id']) {
            Storage::disk('public')->delete($company->background->path);
            $background = Download::find($company->background->id);
        }
        $company->image()->associate(Download::find($validData['image']['id']));
        $company->background()->associate(Download::find($validData['background']['id']));
        $company->category()->associate($validData['category']['id']);
        $company->save();
        isset($image) ?? $image->delete();
        isset($background) ?? $background->delete();
        // Удаление лишних адресов, которые есть сейчас в базе, но в реквесте не пришли
        Address::destroy($company->addresses->pluck('id')->diff(Arr::pluck($request->addresses, 'id'))->values());

        $company->addresses()->saveMany(array_reduce(
            $request->addresses,
            function ($res, $a) {
                // Вытаскиваем по названию город либо создаем новый
                $city = City::firstOrCreate([
                    'name' => $a['city']['name']
                ], [
                    'lat' => $a['city']['lat'],
                    'long' => $a['city']['long']
                ]);
                    
                    if (!empty($a['id'])) {
                        $address = Address::find($a['id']);
                        if ($a['work'] == false) {

                            $address->address = $a['address'];
                            $address->phone = $a['phone'] ?? null;
                            $address->phone2 = $a['phone2'] ?? null;
                            $address->work = null;
                            $address->mon = $a['mon'] ?? null;
                            $address->tues = $a['tues'] ?? null;
                            $address->wed = $a['wed'] ?? null;
                            $address->thurs = $a['thurs'] ?? null;
                            $address->fri = $a['fri'] ?? null;
                            $address->sat = $a['sat'] ?? null;
                            $address->sun = $a['sun'] ?? null;
                            $address->site = $a['site'] ?? null;
                            $address->lat = $a['lat'];
                            $address->long = $a['long'];
                            $address->save();
                        } else {
                            $address->address = $a['address'];
                            $address->phone = $a['phone'] ?? null;
                            $address->phone2 = $a['phone2'] ?? null;
                            $address->work = 'Круглосуточно';
                            $address->mon = '00:00-00:00';
                            $address->tues = '00:00-00:00';
                            $address->wed = '00:00-00:00';
                            $address->thurs = '00:00-00:00';
                            $address->fri = '00:00-00:00';
                            $address->sat = '00:00-00:00';
                            $address->sun = '00:00-00:00';
                            $address->site = $a['site'] ?? null;
                            $address->lat = $a['lat'];
                            $address->long = $a['long'];
                            $address->save();
                        }
                    } else {
                        if ($a['work'] == false) {

                            $address = Address::make([
                                'address' => $a['address'],
                                'phone' => $a['phone'] ?? null,
                                'phone2' => $a['phone2'] ?? null,
                                'work' => null,
                                'mon' => $a['mon'] ?? null,
                                'tues' => $a['tues'] ?? null,
                                'wed' => $a['wed'] ?? null,
                                'thurs' => $a['thurs'] ?? null,
                                'fri' => $a['fri'] ?? null,
                                'sat' => $a['sat'] ?? null,
                                'sun' => $a['sun'] ?? null,
                                'site' => $a['site'] ?? null,
                                'lat' => $a['lat'],
                                'long' => $a['long']
                            ]);
                        } else {
                            $address = Address::make([
                                'address' => $a['address'],
                                'phone' => $a['phone'] ?? null,
                                'phone2' => $a['phone2'] ?? null,
                                'work' => 'Круглосуточно',
                                'mon' => '00:00-00:00',
                                'tues' => '00:00-00:00',
                                'wed' => '00:00-00:00',
                                'thurs' => '00:00-00:00',
                                'fri' => '00:00-00:00',
                                'sat' => '00:00-00:00',
                                'sun' => '00:00-00:00',
                                'site' => $a['site'] ?? null,
                                'lat' => $a['lat'],
                                'long' => $a['long']
                            ]);
                        }
                        array_push($res, $address);
                    }
                $address->city()->associate($city);

                return $res;
            },
            []
        ));

        if (isset($validData['tags'])) {
            $company->tags()->sync(Arr::pluck($validData['tags'], 'id'));
        }
        // Обновление галереи
        $galleryItemIds = Arr::pluck($validData['gallery_items'] ?? [], 'id');
        GalleryItem::destroy($company->gallery_items->pluck('id')->diff($galleryItemIds));
        foreach ($galleryItemIds as $id) {
            // TODO на данный момент если существующее изображение изменится, в базе оно не обновится
            $company->gallery_items()->save(GalleryItem::find($id));
        }

        return $company->load([
            'tags',
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'category',
            'category.tags',
            'changes_log' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'changes_flags'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return int
     */
    public function destroy(Company $company)
    {
        //ПЕРЕНЕСТИ!!!
        foreach ($company->comments as $key => $comment) {
            $comment->delete();
            foreach ($comment->answers as $key => $answer) {
                $answer->delete();
            }
        }
        foreach ($company->user->notifications as $key => $notification) {
            if (isset($notification->data['type']) && isset($notification->data['id'])) {
                if ($notification->data['type'] == Company::class && $notification->data['id'] == $company->id) {
                    $notification->delete();
                }
            }
        }
        foreach ($company->addresses as $key => $address) {
            $address->delete();
        }
        foreach ($company->events as $key => $event) {
            foreach ($event->comments as $key => $comment) {
                $comment->delete();
                foreach ($comment->answers as $key => $answer) {
                    $answer->delete();
                }
            }
            foreach ($event->questions as $key => $question) {
                $question->delete();
                foreach ($question->answers as $key => $answer) {
                    $answer->delete();
                }
            }
            foreach ($event->user->notifications as $key => $notification) {
                if (isset($notification->data['type']) && isset($notification->data['id'])) {
                    if ($notification->data['type'] == Event::class && $notification->data['id'] == $event->id) {
                        $notification->delete();
                    }
                }
            }
            $event->addresses()->detach();
            $event->delete();
        }

        $company->reports()->delete();
        $company->gallery_items()->delete();
        $image = $company->image();
        $background = $company->background();
        $company->ratings()->delete();
        $company->rating_results()->delete();
        $company->recommendations()->delete();
        $company->recommendation_result()->delete();
        $company->user->removeRole('company');
        $result = Company::destroy($company->id);
        $image->delete();
        $background->delete();
        return $result;
    }

    public function count()
    {
        return Company::count();
    }

    // функция производит поиск компаний по базе по переданной строке
    // если строка является числом, то происходит точная выборка id
    // если строка, то поиск идет только по названию компании
    public function search(Request $request, $string)
    {
        $query = Company::query();

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
