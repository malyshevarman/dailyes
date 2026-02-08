<?php

namespace App\Http\Controllers\Api\Backend\Banner;

use App\BannerPlace;
use App\City;
use App\Download;
use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $request)
    {
        $query = Banner::join('banner_places as places', 'places.id', '=', 'banners.place_id');

        if (!empty($request->search['text'])) {
            $query->where('banners.name', 'LIKE', '%' . $request->search['text'] . '%');
        }
        
        if (!empty($request->search['city'])) {
            $city_id = $request->search['city'];
            if ($city_id !== 0) {
                $query->where('banners.city_id', $city_id);
            }
        }

        $items = $query
       ->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
       ->select('banners.*')       // just to avoid fetching anything from joined table
       ->with(['place','city'])         // if you need options data anyway
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
            'download.id' => 'required|exists:downloads,id',
            'mobile.id' => 'required|exists:downloads,id',
            'place.id' => 'required|exists:banner_places,id',
            'city.id' => 'required|exists:cities,id',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'link' => 'required|url',
        ]);

        $banner = Banner::make($validData);
        $banner->download()->associate(Download::find($validData['download']['id']));
        $banner->mobile()->associate(Download::find($validData['mobile']['id']));
        $banner->place()->associate(BannerPlace::find($validData['place']['id']));
        $banner->city()->associate(City::find($validData['city']['id']));
        $banner->save();

        return $banner->load([
            'download',
            'place'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return $banner->load([
            'download',
            'mobile',
            'place',
            'city'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Banner $banner
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Banner $banner)
    {
        $validData = $this->validate($request, [
            'download.id' => 'required|exists:downloads,id',
            'mobile.id' => 'required|exists:downloads,id',
            'place.id' => 'required|exists:banner_places,id',
            'city.id' => 'required|exists:cities,id',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s',
            'link' => 'required|url',
        ]);

        $banner->fill($validData);
        if ($banner->download->id !== $validData['download']['id']) {
            Storage::disk('public')->delete($banner->download->path);
            $download = Download::find($banner->download->id);
        }
        if ($banner->mobile->id !== $validData['mobile']['id']) {
            Storage::disk('public')->delete($banner->mobile->path);
            $mobile = Download::find($banner->mobile->id);
        }
        $banner->download()->associate(Download::find($validData['download']['id']));
        $banner->mobile()->associate(Download::find($validData['mobile']['id']));
        $banner->place()->associate(BannerPlace::find($validData['place']['id']));
        $banner->city()->associate(City::find($validData['city']['id']));
        $banner->save();
        isset($download) ?? $download->delete();
        isset($mobile) ?? $mobile->delete();
        return $banner->load([
            'download',
            'place',
            'city'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Banner $banner
     * @return int
     * @throws \Exception
     */
    public function destroy(Banner $banner)
    {
        return response()->json($banner->delete());
    }
}
