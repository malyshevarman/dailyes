<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventView extends Model
{
    protected $fillable = ['event_id', 'date', 'count'];
}
