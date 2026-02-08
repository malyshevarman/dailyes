<?php

namespace App\Http\Controllers\Api\Frontend\CallbackOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\CallbackOrder\CallbackOrdered;
use App\Notifications\CallbackOrder\ContactPageCallbackOrdered;
use App\Notifications\CallbackOrder\AdvertisingPageCallbackOrdered;
use Storage;
use Notification;

class CallbackOrderController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function callback(Request $request)
    {
        $validData = $this->validate($request, [
            'phone' => 'required|string',
            'name'  => 'required|string',
            'agreement' => 'required|accepted',

        ]);
        // $user = \App\User::find(1);
        $notification = Notification::route('mail', 'biz@dailyes.ru')->notify(new CallbackOrdered($validData));

        return 'true';
    }

    public function contactPageCallback(Request $request)
    {
        $validData = $this->validate($request, [
            'phone' => 'required|string',
            'name'  => 'required|string',
            'agreement' => 'required|accepted',
            'city'  => 'required|string',
            'subject' => 'required|string',
            'mail' => 'email:rfc,dns',
            'description' => 'required|string',
            // 'attachment' => 'required|file'
        ]);
        // так сделал, чтобы нормально сохранял svg файлы и другие
        if (!empty($request->attachment)) {
            $path = Storage::putFileAs('uploads/callback_orders', $request->attachment, time() . rand(1111, 9999) . '.' . $request->attachment->getClientOriginalExtension());
            $validData['attachment'] = $path;
        }

        // $user = \App\User::find(1);
        if ($request->subject == 'Проблема с оплатой' || $request->subject == 'Запрос информации' || $request->subject == 'Сообщить об ошибке') {
            $notification = Notification::route('mail', 'support@dailyes.ru')->notify(new ContactPageCallbackOrdered($validData));
        } else if ($request->subject == 'Предложение по сотрудничеству') {
            $notification = Notification::route('mail', 'biz@dailyes.ru')->notify(new ContactPageCallbackOrdered($validData));
        } else if ($request->subject == 'Другой вопрос') {
            $notification = Notification::route('mail', 'hello@dailyes.ru')->notify(new ContactPageCallbackOrdered($validData));
        }

        return 'true';
    }

    public function advertisingPageCallback(Request $request)
    {
        $validData = $this->validate($request, [
            'phone' => 'required|string',
            'name'  => 'required|string',
            'agreement' => 'required|accepted',
            'site_link'  => 'nullable|string',
            'mail' => 'email:rfc,dns',
            'description' => 'nullable|string'
        ]);

        // $user = \App\User::find(1);
        $notification = Notification::route('mail', 'ad@dailyes.ru')->notify(new AdvertisingPageCallbackOrdered($validData));

        return 'true';
    }
}
