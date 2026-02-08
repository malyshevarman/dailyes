<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\CommentAnswer\Updated;

class CommentAnswer extends Model
{
    protected $fillable = ['text', 'published', 'rejected', 'is_moderated', 'message'];

    protected $casts = [
        'published' => 'boolean'
    ];

        protected $dispatchesEvents = [
        // 'created' => Created::class,
        'updated' => Updated::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1)->where('is_moderated', 1)->where('rejected', 0);
    }
}
