<?php

namespace App;

use App\Notifications\Auth\ResetPassword;
use App\Notifications\Auth\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

use Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'last_name', 'city', 'phone', 'birth_date', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at', 'birth_date'];

    protected $appends = ['avatar_url', 'city_slug'];

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/' . $this->id . '/' . $this->avatar);
    }

    public function providers()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function favorite_events()
    {
        return $this->belongsToMany(Event::class, 'user_has_favorite_events', 'user_id', 'event_id')->withTimestamps();
    }

    public function favorite_companies()
    {
        return $this->belongsToMany(Company::class, 'user_has_favorite_companies', 'user_id', 'company_id')->withTimestamps();
    }

    public function restricted_notifications()
    {
        return $this->belongsToMany(NotificationSettings::class, 'user_has_restricted_notification_settings', 'user_id', 'notification_settings_id')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, Company::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function getCitySlugAttribute()
    {
        $city = \App\City::where('name', $this->city)->first();

        return is_null($city) ? null : $city->slug;
    }
}
