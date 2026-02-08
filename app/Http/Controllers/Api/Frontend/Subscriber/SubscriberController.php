<?php

namespace App\Http\Controllers\Api\Frontend\Subscriber;

use App\Http\Controllers\Controller;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Notifications\Subscriber\SubscriberSubscribe;
class SubscriberController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribe(Request $request)
    {
        $validData = $this->validate($request, [
            'email' => 'required|email|unique:subscribers,email',
            'name'  => 'nullable|string'
        ]);

        $subscriber = Subscriber::create($validData);

        $subscriber->notify(new SubscriberSubscribe());
        return $subscriber;
    }

    public function unsubscribe($id)
    {
        Subscriber::destroy($id);
        // return response()->json(Subscriber::find($id));
        // $validData = $this->validate($request, [
        //     'email' => 'required|email|unique:subscribers,email',
        //     'name'  => 'nullable|string'
        // ]);

        // $subscriber = Subscriber::create($validData);

        // $subscriber->notify(new SubscriberSubscribe());
        // return redirect()->route('frontend.city.show', ['message' => ['text' => 'Вы успешно отписались от e-mail рассылки']]);
        return redirect('/')->with('message', ['text' => 'Вы успешно отписались от e-mail рассылки']);
    }
}
