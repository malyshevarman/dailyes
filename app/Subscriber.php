<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class Subscriber extends Model
{
	use Notifiable;
	use HasRoles;
	
    protected $fillable = [
        'email',
        'name'
    ];
}
