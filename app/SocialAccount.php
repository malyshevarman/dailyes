<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $table = 'social_accounts';

    protected $fillable = ['user_id', 'provider', 'provider_id', 'token', 'avatar'];
}
