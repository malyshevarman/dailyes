<?php

namespace App\Http\Controllers\Api\Backend\Company\Address;

use App\Address;
use App\City;
use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'city.name' => 'required|string',
            'city.lat' => 'required|numeric',
            'city.long' => 'required|numeric',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            // 'work' => 'nullable|string',
            'mon' => 'nullable|string',
            'tues' => 'nullable|string',
            'wed' => 'nullable|string',
            'thurs' => 'nullable|string',
            'fri' => 'nullable|string',
            'sat' => 'nullable|string',
            'sun' => 'nullable|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'site' => 'string'
        ]);

        // Вытаскиваем по названию город либо создаем новый
        $city = City::firstOrCreate([
            'name' => $validData['city']['name']
        ], [
            'lat' => $validData['city']['lat'],
            'long' => $validData['city']['long']
        ]);

        // создаем адрес, присваиваем компанию и город и после сохраняем
        $address = Address::make([
            'address' => $validData['address'],
            'phone' => $validData['phone'] ?? null,
            // 'work' => $validData['work'] ?? null,
            'mon' => $validData['mon'] ?? null,
            'tues' => $validData['tues'] ?? null,
            'wed' => $validData['wed'] ?? null,
            'thurs' => $validData['thurs'] ?? null,
            'fri' => $validData['fri'] ?? null,
            'sat' => $validData['sat'] ?? null,
            'sun' => $validData['sun'] ?? null,
            'site' => $validData['site'] ?? null,
            'lat' => $validData['lat'],
            'long' => $validData['long']
        ]);

        $address->company()->associate($company);
        $address->city()->associate($city);

        $address->save();

        return json_encode($address);
    }

    /**
     * Display the specified resource.
     *
     * @param Address $address
     * @return Address
     */
    public function show(Company $company, Address $address)
    {
        return $address->load([
            'city'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Company $company
     * @param Address $address
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Company $company, Address $address)
    {
        $validData = $this->validate($request, [
            'city.name' => 'required|string',
            'city.lat' => 'required|numeric',
            'city.long' => 'required|numeric',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            // 'work' => 'nullable|string',
            'mon' => 'nullable|string',
            'tues' => 'nullable|string',
            'wed' => 'nullable|string',
            'thurs' => 'nullable|string',
            'fri' => 'nullable|string',
            'sat' => 'nullable|string',
            'sun' => 'nullable|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'site' => 'string'
        ]);

        // Вытаскиваем по названию город либо создаем новый
        $city = City::firstOrCreate([
            'name' => $validData['city']['name']
        ], [
            'lat' => $validData['city']['lat'],
            'long' => $validData['city']['long']
        ]);

        $address->update([
            'address' => $validData['address'],
            'phone' => $validData['phone'] ?? null,
            // 'work' => $validData['work'] ?? null,
            'mon' => $validData['mon'] ?? null,
            'tues' => $validData['tues'] ?? null,
            'wed' => $validData['wed'] ?? null,
            'thurs' => $validData['thurs'] ?? null,
            'fri' => $validData['fri'] ?? null,
            'sat' => $validData['sat'] ?? null,
            'sun' => $validData['sun'] ?? null,
            'site' => $validData['site'] ?? null,
            'lat' => $validData['lat'],
            'long' => $validData['long']
        ]);

        $address->city()->associate($city);
        $address->save();

        return json_encode($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @param Address $address
     * @return int
     * @throws \Exception
     */
    public function destroy(Company $company, Address $address)
    {
        return json_encode($address->delete());
    }
}
