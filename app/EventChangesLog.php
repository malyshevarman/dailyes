<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventChangesLog extends Model
{
    protected $table = 'event_changes_log';

    protected $fillable = ['event_id', 'user_id', 'original_data', 'changed_data', 'route'];

    protected $casts = [
        'original_data' => 'array',
        'changed_data' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
