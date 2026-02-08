<?php

namespace App;

use App\Events\Comment\Created;
use App\Events\Comment\Updated;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text', 'published', 'rejected', 'is_moderated', 'message'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'created' => Created::class,
        'updated' => Updated::class
    ];

    public function commented()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(CommentAnswer::class, 'comment_id');
    }

    public function getStarAttribute()
    {
        return $this->commented->user_rating ? $this->commented->user_rating->star : null;
    }

    public function getRecAttribute()
    {
        return $this->commented->user_recommendation ? $this->commented->user_recommendation->bool : null;
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1)->where('is_moderated', 1)->where('rejected', 0);
    }
}
