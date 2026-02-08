<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSettings extends Model
{
    protected $fillable = ['name', 'type'];


    public function users_who_have_added_to_restricted()
    {
        return $this->belongsToMany(User::class, 'user_has_restricted_notification_settings', 'notification_settings_id', 'user_id')->withTimestamps();
    }

    public function toggle()
    {
        return $this->users_who_have_added_to_restricted()->toggle(Auth()->user());
    }
}
