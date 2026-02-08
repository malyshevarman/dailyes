<?php

namespace App\Http\Controllers\Auth;

use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\Socialite as SocialiteHelper;
use Storage;

use Avatar;

/**
 * Class SocialLoginController.
 */
class SocialLoginController extends Controller
{
    /**
     * @var SocialiteHelper
     */
    protected $socialiteHelper;

    /**
     * SocialLoginController constructor.
     *
     * @param SocialiteHelper $socialiteHelper
     */
    public function __construct(SocialiteHelper $socialiteHelper)
    {
        $this->socialiteHelper = $socialiteHelper;
    }

    /**
     * @param Request $request
     * @param $provider
     *
     * @throws GeneralException
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function login(Request $request, $provider)
    {
        // There's a high probability something will go wrong
        $user = null;

        // If the provider is not an acceptable third party than kick back
        if (!in_array($provider, $this->socialiteHelper->getAcceptedProviders())) {
            return redirect('/')->withFlashDanger(':provider не приемлемый тип для входа.', ['provider' => $provider]);
        }

        /*
         * The first time this is hit, request is empty
         * It's redirected to the provider and then back here, where request is populated
         * So it then continues creating the user
         */
        if (!$request->all()) {
            return $this->getAuthorizationFirst($provider);
        }

        // Create the user if this is a new social account or find the one that is already there.
        try {
            $user = $this->findOrCreateProvider($this->getProviderUser($provider), $provider);
        } catch (GeneralException $e) {
            return redirect('/')->withFlashDanger($e->getMessage());
        }

        if (is_null($user)) {
            return redirect('/')->withFlashDanger(__('exceptions.frontend.auth.unknown'));
        }

        // TODO Check to see if they are active.
//        if (!$user->isActive()) {
//            throw new GeneralException('Ваша учетная запись была деактивирована.');
//        }

        // TODO Account approval is on
//        if ($user->isPending()) {
//            throw new GeneralException(__('В настоящее время ваша учетная запись находится на рассмотрении.'));
//        }

        // User has been successfully created or already exists
        auth()->login($user, true);

        // Set session variable so we know which provider user is logged in as, if ever needed
//        session([config('access.socialite_session_name') => $provider]);
        session(['socialite_provider' => $provider]);

//        event(new UserLoggedIn(auth()->user()));

        // Return to the intended url or default to the class property
        return redirect()->intended('/');
    }

    /**
     * @param  $provider
     *
     * @return mixed
     */
    protected function getAuthorizationFirst($provider)
    {
        $socialite = Socialite::driver($provider);
        $scopes = empty(config("services.{$provider}.scopes")) ? false : config("services.{$provider}.scopes");
        $with = empty(config("services.{$provider}.with")) ? false : config("services.{$provider}.with");
        $fields = empty(config("services.{$provider}.fields")) ? false : config("services.{$provider}.fields");

        if ($scopes) {
            $socialite->scopes($scopes);
        }

        if ($with) {
            $socialite->with($with);
        }

        if ($fields) {
            $socialite->fields($fields);
        }

        return $socialite->redirect();
    }

    /**
     * @param $provider
     *
     * @return mixed
     */
    protected function getProviderUser($provider)
    {
        return Socialite::driver($provider)->user();
    }

    /**
     * @param $data
     * @param $provider
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findOrCreateProvider($data, $provider)
    {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
//        $user = $this->getByColumn($user_email, 'email');
        $user = User::where('email', $user_email)->first();

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (!$user) {
            // TODO Registration is not enabled
//            if (!config('access.registration')) {
//                throw new GeneralException('Регистрация в настоящее время закрыта, приходите позже');
//            }

            // TODO Get users first name and last name from their full name
//            $nameParts = $this->getNameParts($data->getName());

//            $user = User::create([
////                'first_name' => $nameParts['first_name'],
////                'last_name' => $nameParts['last_name'],
//                'name' => $data->getName(),
//                'email' => $user_email,
////                'active' => 1,
////                'confirmed' => 1,
//                'password' => null,
////                'avatar_type' => $provider,
//            ]);

            $user = User::create([
                'name' => $data->getName(),
                'email' => $user_email,
                'password' => null,
            ]);

            $user->assignRole('user');

            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('avatars/' . $user->id . '/avatar.png', (string)$avatar);

//            event(new UserProviderRegistered($user));
        }

        // See if the user has logged in with this social account before
        if (!$user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialAccount([
                'provider' => $provider,
                'provider_id' => $data->id,
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]);

//            $user->avatar_type = $provider;
            $user->update();
        }

        // Return the user object
        return $user;
    }
}
