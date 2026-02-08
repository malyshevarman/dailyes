<?php

namespace App;

use App\Events\Page\PageChanged;
use App\Events\Page\PageDeleted;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected $fillable = [
        'name', 'path', 'view', 'title', 'description', 'breadcrumbs', 'h1', 'summary', 'content'
    ];

    protected $casts = [
        'breadcrumbs' => 'array',
    ];

    protected $dispatchesEvents = [
        'saved' => PageChanged::class,
        'deleted' => PageDeleted::class,
    ];

    public function sluggable()
    {
        return [
            'path' => [
                'source' => 'name'
            ]
        ];
    }
}
