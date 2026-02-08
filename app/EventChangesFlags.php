<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventChangesFlags extends Model
{
    protected $table = 'event_changes_flags';

	public $timestamps = false;

    protected $fillable = [
    	'event_id',
    	'is_changed_company',
	    'is_changed_name',
	    'is_changed_summary',
	    'is_changed_about',
	    'is_changed_categories',
	    'is_changed_slug',
	    'is_changed_image_download_id',
	    'is_changed_background_download_id',
	    'is_changed_gallery_items',
	    'is_changed_addresses',
	    'is_changed_user',
    ];

    protected $casts = [
    	'is_changed_company' => 'boolean',
        'is_changed_name' => 'boolean',
	    'is_changed_summary' => 'boolean',
	    'is_changed_about' => 'boolean',
	    'is_changed_categories' => 'boolean',
	    'is_changed_slug' => 'boolean',
	    'is_changed_image_download_id' => 'boolean',
	    'is_changed_background_download_id' => 'boolean',
	    'is_changed_gallery_items' => 'boolean',
	    'is_changed_addresses' => 'boolean',
	    'is_changed_user' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
