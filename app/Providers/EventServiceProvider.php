<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Verified' => [
            'App\Listeners\SendWelcomeListener',
        ],
        'App\Events\Comment\Updated' => [
            'App\Listeners\Comment\SendCommentListener',
        ],
        'App\Events\CommentAnswer\Updated' => [
            'App\Listeners\CommentAnswer\SendCommentAnswerListener',
        ],
        'Illuminate\Notifications\Events\NotificationSending' => [
            'App\Listeners\CheckUserNotificationSettingsListener',
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\\VKontakte\\VKontakteExtendSocialite@handle',
            'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
            'SocialiteProviders\\Odnoklassniki\\OdnoklassnikiExtendSocialite@handle',
            'SocialiteProviders\\Instagram\\InstagramExtendSocialite@handle'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
