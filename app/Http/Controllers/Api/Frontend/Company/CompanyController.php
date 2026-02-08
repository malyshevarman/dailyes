<?php

namespace App\Http\Controllers\Api\Frontend\Company;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\Company\CompanyOwner;

class CompanyController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function feature(Request $request)
    {
        $validData = $this->validate($request, [
            'slug' => 'required|exists:companies,slug'
        ]);

        $company = Company::where('slug', $validData['slug'])->firstOrFail();

        return $company->feature();
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function rating(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'star' => 'required|numeric|between:1,5'
        ]);
        $rat = auth()->user()->ratings()->where('estimated_id', $company->id)->where('estimated_type', 'App\Company')->first();

        if (empty($rat)) {
            $rat = auth()->user()->ratings()->make([
                'star' => $validData['star']
            ]);
            return $company->ratings()->save($rat);
        } else {
            if ($rat->star === $validData['star']) {
                $rat->delete();
                return 'deleted';
            } else {
                $rat->star = $validData['star'];
                $rat->save();
                return $company->ratings()->save($rat);
            }
        }
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function recommendation(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'bool' => 'required|boolean'
        ]);
        $rec = auth()->user()->recommendations()->where('recommendable_id', $company->id)->where('recommendable_type', 'App\Company')->first();

        if (empty($rec)) {
            $rec = auth()->user()->recommendations()->make([
                'bool' => $validData['bool']
            ]);
            return $company->recommendations()->save($rec);
        } else {
            if ($rec->bool === $validData['bool']) {
                $rec->delete();
                return 'deleted';
            } else {
                $rec->bool = $validData['bool'];
                $rec->save();
                return $company->recommendations()->save($rec);
            }
        }
    }

    public function submitOwner(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'verification_email' => 'email:rfc,dns'
        ]);
        if ($company->verification_email == $validData['verification_email']) {
            $validData['user_id'] = auth()->id();
            $validData['company'] = $company;
            $notification = $company->notify(new CompanyOwner($validData));

            return response()->json(['success' => 'Ссылка отправлена на указанный электронный адрес.'], 200);
        } else {
            return response()->json(['errors' => ['verification_email' => 'Введенный e-mail неверен.']], 422);
        }
        // $user = \App\User::find(1);
    }
}
