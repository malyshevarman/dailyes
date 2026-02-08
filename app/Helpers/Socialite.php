<?php

namespace App\Helpers;

class Socialite
{
    public function getAcceptedProviders()
    {
        return [
            'vkontakte',
            'facebook',
            'odnoklassniki',
            'instagram'
        ];
    }
}