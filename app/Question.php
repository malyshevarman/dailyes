<?php

namespace App;

use App\Events\Question\Created;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['text', 'published'];

    protected $dispatchesEvents = [
        'created' => Created::class
    ];

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
