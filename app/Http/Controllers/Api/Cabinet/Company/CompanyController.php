<?php

namespace App\Http\Controllers\Api\Cabinet\Company;

use App\Company;
use App\City;
use App\Address;
use App\Download;
use App\GalleryItem;
use App\Http\Controllers\Controller;
use App\Notifications\Company\CompanyDelete;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
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
        Validator::extend('check_working_days', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $addresses = $inputs['addresses'];
            foreach ($addresses as $key => $address) {
                if ($address['mon'] == '00:00-00:00' && $address['tues'] == '00:00-00:00' && $address['wed'] == '00:00-00:00' && $address['thurs'] == '00:00-00:00' && $address['fri'] == '00:00-00:00' && $address['sat'] == '00:00-00:00' && $address['sun'] == '00:00-00:00') {
                    return true;
                }

                return false;
            }
        });

        $validData = $this->validate($request, [
            'name' => 'required|string|unique:companies,name',
            'url' => 'nullable|url',
            'summary' => 'nullable|string',
            'about' => 'required|nullable|string',
            'image' => 'required|array',
            'image.id' => 'exists:downloads,id',
            'background' => 'required|array',
            'background.id' => 'exists:downloads,id',
            'gallery_items' => 'array',
            // 'categories' => 'required|array|exists:categories,id',
            'category' => 'required',
            // 'category.*.id' => 'exists:categories,id',
            'addresses' => 'required',
            'tags' => 'required|array',
            'addresses.*.city.name' => 'required|string',
            // 'addresses.*.city.lat' => 'required|numeric',
            // 'addresses.*.city.long' => 'required|numeric',
            'addresses.*.address' => 'required|string',
            'addresses.*.phone' => 'required|string',
            'addresses.*.site' => 'required|string',
            // 'addresses.*.phone2' => 'nullable|string',
            'addresses.*.work' => 'nullable|boolean',
            'addresses.*.mon' => 'required_if:addresses.*.work,false',
            'addresses.*.tues' => 'required_if:addresses.*.work,false',
            'addresses.*.wed' => 'required_if:addresses.*.work,false',
            'addresses.*.thurs' => 'required_if:addresses.*.work,false',
            'addresses.*.fri' => 'required_if:addresses.*.work,false',
            'addresses.*.sat' => 'required_if:addresses.*.work,false',
            'addresses.*.sun' => 'required_if:addresses.*.work,false',
            'addresses' => 'check_working_days'
            // 'addresses.*.lat' => 'required|numeric',
            // 'addresses.*.long' => 'required|numeric',
            // 'addresses.*.site' => 'string'
        ], [
            'check_working_days' => 'Поле режим работы обязателен', // <---- pass a message for your custom validator
        ]);

        $company = Company::make($validData);
        $company->active = false;
        $company->image()->associate(Download::find($validData['image']['id']));
        $company->background()->associate(Download::find($validData['background']['id']));
        $company->user()->associate(\Auth::user());
        $company->category()->associate($validData['category']['id']);
        $company->save();
        \Auth::user()->assignRole('company');
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
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'category',
            'tags',
            'category.tags',
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
        if ($company->user->id != \Auth::id()) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }

        return $company->load([
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
            'tags',
            'category.tags',
        ]);
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
        if ($company->user->id != \Auth::id()) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }

        Validator::extend('check_working_days', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $addresses = $inputs['addresses'];
            foreach ($addresses as $key => $address) {
                if ($address['mon'] == '00:00-00:00' && $address['tues'] == '00:00-00:00' && $address['wed'] == '00:00-00:00' && $address['thurs'] == '00:00-00:00' && $address['fri'] == '00:00-00:00' && $address['sat'] == '00:00-00:00' && $address['sun'] == '00:00-00:00') {
                    return false;
                }

                return true;
            }
        });

        $validData = $this->validate($request, [
            'name' => 'required|string|unique:companies,name,' . $request->id,
            'url' => 'nullable|url',
            'summary' => 'nullable|string',
            'about' => 'required|nullable|string',
            'image' => 'required|array',
            'image.id' => 'exists:downloads,id',
            'background' => 'required|array',
            'background.id' => 'exists:downloads,id',
            'gallery_items' => 'array',
            'category' => 'required',
            // 'category.*.id' => 'exists:categories,id',
            'published' => 'required|boolean',
            // 'active' => 'required|boolean',
            'rejected' => 'required|boolean',
            'tags' => 'required|array',
            'addresses' => 'required',
            'addresses.*.city.name' => 'required|string',
            // 'addresses.*.city.lat' => 'required|numeric',
            // 'addresses.*.city.long' => 'required|numeric',
            'addresses.*.address' => 'required|string',
            'addresses.*.phone' => 'required|string',
            'addresses.*.site' => 'required|string',
            // 'addresses.*.phone2' => 'nullable|string',
            'addresses.*.work' => 'nullable|boolean',
            'addresses.*.mon' => 'required_if:addresses.*.work,false',
            'addresses.*.tues' => 'required_if:addresses.*.work,false',
            'addresses.*.wed' => 'required_if:addresses.*.work,false',
            'addresses.*.thurs' => 'required_if:addresses.*.work,false',
            'addresses.*.fri' => 'required_if:addresses.*.work,false',
            'addresses.*.sat' => 'required_if:addresses.*.work,false',
            'addresses.*.sun' => 'required_if:addresses.*.work,false',
            'addresses' => 'check_working_days'
            // 'addresses.*.lat' => 'required|numeric',
            // 'addresses.*.long' => 'required|numeric',
            // 'addresses.*.site' => 'string'

        ], [
            'check_working_days' => 'Поле режим работы обязателен', // <---- pass a message for your custom validator
        ]);

        if ($validData['rejected']) {
            $validData['rejected'] = false;
        }

        $company->fill($validData);
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
        $company->user()->associate(\Auth::user());

        // if ($company->rejected == 1) {
        //     $company->rejected = 0;
        //     $company->published = 0;
        //     $company->active = 0;
        // }

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
            'gallery_items',
            'gallery_items.attachable',
            'background',
            'image',
            'addresses',
            'addresses.city',
            'category',
            'tags',
            'category.tags',
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


        if ($company->user->id != \Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $notifi = DB::table('notifications')->where('data->id', '=', $company->id)->delete();

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
        $result = Company::destroy($company->id);
        $image->delete();
        $background->delete();

        //уведомляем пользваотеля
        $validData['company'] = $company;
        $validData['user_name'] = Auth::user()->name;
        $company->verification_email = Auth::user()->email;
        $company->user->notify(new CompanyDelete($company));
        \Auth::user()->removeRole('company');
        return $result;
    }

    // функция производит поиск компаний по базе по переданной строке
    // если строка является числом, то происходит точная выборка id
    // если строка, то поиск идет только по названию компании
    public function search(Request $request, $string)
    {
        $query = Company::whereHas('user', function ($query) {
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

    // public function status(Request $request, $id)
    // {
    //     $company = Company::find($id);

    //     $notifi = DB::table('notifications')->where('data->id', '=', $id)->delete();

    //     if ($company->active && $company->published) {
    //         $company->published = false;
    //         $company->active = false;
    //     } else {
    //         $company->published = true;
    //         $company->active = true;
    //     }
    //     $company->save();
    //     return redirect()->route('cabinet.company.index');
    // }

    public function getCompanies(Request $request)
    {
        $query = Company::whereHas('user', function ($query) {
            $query->where('id', \Auth::id());
        });

        $items = $query->get();

        return $items;
    }

    public function submitOwner(Request $request, Company $company)
    {
        if ($request->input('token') && $request->input('token') == $company->verify_token) {
            if (\Auth::id() == $request->input('user_id')) {
                $company->user_id = \Auth::id();
                $company->user->assignRole('company');
                $company->save();
                return redirect()->route('cabinet.company.edit', $company);
            } else {
                return response()->json(['error' => 'Page not found.'], 404);
            }
        } else {
            return 'token is not valid';
        }
    }
}
