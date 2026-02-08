<?php

namespace App\Http\Controllers\Api\Cabinet\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NotificationSettings;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotificationSettings::all()->toArray();
    }

    public function userSettings() {
        return Auth()->user()->restricted_notifications;
    }

    public function toggle(Request $request)
    {
        // dd($request->all());
        // $desired_object = Auth()->user()->restricted_notifications->filter(function($item) use ($request) {
            // return $item->id == $request->id;
        // })->first();

        // if ($desired_object) {
        if ($request->all) {
            Auth()->user()->restricted_notifications()->sync($request->data);
        } else {
            Auth()->user()->restricted_notifications()->toggle($request->data);
        }
        // } else {
        //     Auth()->user()->restricted_notifications()->attach($request->id);
        // }
        // if (Auth()->user()->restricted_notifications->count() > 0) {
        //     foreach (Auth()->user()->restricted_notifications as $key => $value) {
        //         if ($value->id == $request->id) {
        //             Auth()->user()->restricted_notifications()->detach($request->id);
        //         }
        //     }
        // } else {
        //     Auth()->user()->restricted_notifications()->attach($request->id);
        // }
        // $resNot = Auth()->user()->restricted_notifications()->find($request->id);
        // dd($resNot);
        // if ($resNot) {
            
        // }
        // dd();
        // $notifications = NotificationSettings::find($request->all());
        // foreach ($notifications as $key => $value) {
        //     $value->toggle();
        // }
        // Auth()->user()->restricted_notifications()->sync($request->id);
        return Auth()->user()->restricted_notifications;
    }
}
