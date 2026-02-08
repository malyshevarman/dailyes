<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Event extends Model
{
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = ['name', 'slug', 'summary', 'published', 'rejected', 'message', 'active', 'start', 'end', 'about', 'star', 'rec', 'view', 'favorite'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $casts = [
        'published' => 'boolean',
        'rejected' => 'boolean',
        'active' => 'boolean',
        'favorite' => 'boolean'
    ];

    protected $appends = [
        // 'image_url', 
        // 'background_url', 
        // 'user_rating', 
        // 'user_recommendation', 
        // 'event_url',
        // 'status'
    ];

    protected $dates = ['start', 'end'];

    public function changes_log() {
        return $this->hasMany(EventChangesLog::class);
    }

    public function changes_flags() {
        return $this->hasOne(EventChangesFlags::class, 'event_id', 'id');
    }

    // // TODO удалить отношение, так как создал просто categories
    // public function event_categories()
    // {
    //     return $this->belongsToMany(EventCategory::class, 'event_has_event_categories');
    // }

    // public function seo()
    // {
    //     return $this->morphOne(Seo::class, 'seoable');
    // }

    // public function category()
    // {
    //     return $this->company->first()->category;
    // }

    public function tags()
    {
        return $this->belongsToMany(CategoriesTag::class, 'event_has_categories_tags');
    }

    public function labels()
    {
        return $this->belongsToMany(EventLabel::class, 'event_has_event_labels', 'event_id', 'label_id')
            ->where(function ($query) {
                $query
                    ->where('event_has_event_labels.start', '<=', date('Y-m-d'))
                    ->orWhere('event_has_event_labels.start', null);
            })
            ->where(function ($query) {
                $query
                    ->where('event_has_event_labels.end', '>=', date('Y-m-d'))
                    ->orWhere('event_has_event_labels.end', null);
            });
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'event_has_addresses');
    }

    public function event_views()
    {
        return $this->hasMany(EventView::class);
    }

    public function views_today()
    {
        return $this->hasOne(EventView::class)->whereDate('date', date("Y-m-d"));
    }

    public function views_weekly()
    {
        return $this->hasMany(EventView::class)->whereDate('date', '>=', date("Y-m-d", strtotime("-7 day")));
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function gallery_items()
    {
        return $this->morphMany(GalleryItem::class, 'model');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function image()
    {
        return $this->belongsTo(Download::class, 'image_download_id');
    }

    public function background()
    {
        return $this->belongsTo(Download::class, 'background_download_id');
    }

    public function users_who_have_added_to_favorites()
    {
        return $this->belongsToMany(User::class, 'user_has_favorite_events', 'event_id', 'user_id')->withTimestamps();
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'estimated');
    }

    public function recommendations()
    {
        return $this->morphMany(Recommendation::class, 'recommendable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commented');
    }

    public function rating_results()
    {
        return $this->morphMany(RatingResult::class, 'estimated')->orderBy('star', 'desc');
    }

    public function recommendation_result()
    {
        return $this->morphOne(RecommendationResult::class, 'recommendable');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    // public function selections()
    // {
    //     return $this->morphToMany(Selection::class, 'model', 'selection_has_models');
    // }

    public function user()
    {
        return $this->hasOneThrough(User::class, Company::class, 'id', 'id', 'company_id', 'user_id');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image) || !Storage::exists($this->image->path)) {
            return 'http://via.placeholder.com/285x200';
        }
        return Storage::url($this->image->path);
    }

    public function getBackgroundUrlAttribute()
    {
        if (empty($this->background) || !Storage::exists($this->background->path)) {
            return 'http://via.placeholder.com/1440x750';
        }
        return Storage::url($this->background->path);
    }

    public function getRelatedEventsAttribute()
    {
        return self::whereHas('tags', function ($query) {
            $query->whereIn('id', $this->tags->pluck('id'));
        })->whereHas('addresses', function ($query) {
            $query->whereIn('city_id', $this->addresses->pluck('city_id'));
        })->where('id', '!=', $this->id)->active()->inRandomOrder()->limit(6)->get();
    }

    public function getStatusAttribute()
    {
        $date = Carbon::today();
        if ($date->gte($this->start) && $date->lte($this->end) || $this->end == NULL) {
            return 'active';
        } else if ($date->lt($this->start)) {
            return 'before';
        } else if ($date->gt($this->end)) {
            return 'after';
        } else {
            return false;
        }
    }

    public function getUserRatingAttribute()
    {
        if (auth()->user()) {
            return $this->ratings()->where('user_id', auth()->user()->id)->first();
        }
        return null;
    }

    public function getUserRecommendationAttribute()
    {
        if (auth()->user()) {
            return $this->recommendations()->where('user_id', auth()->user()->id)->first();
        }
        return null;
    }

    // добавляет просмотр
    // TODO перенести в кеш redis, чтобы не слать UPDATE при каждом просмотре
    public function addView()
    {
        if ($_SERVER['HTTP_ACCEPT'] == '*/*') {
            return false;
        }

        $this->views_today()->firstOrCreate([
            'date' => date("Y-m-d")
        ])->increment('count');
        $this->increment('views');

        return true;
    }

    public function addRecentlyViewedList()
    {
        // Configuration Variables
        $num_to_store = 100; // If there are more than this many stored, delete the oldest one
        $minutes_to_store = 1440; // These cookies will automatically be forgotten after this number of minutes. 1440 is 24 hours.

        // Get the existing cookie data from the user
        $recent = \Cookie::get('recently_viewed_events');

        // Since cookies must be strings, the data is stored as JSON.
        // Decode the data.
        // The second parameter, "[w]hen TRUE, returned objects will be
        // converted into associative arrays."
        $recent = json_decode($recent, TRUE);

        // If the URL already exists in the user's history, delete the older one
        // Note -- If there are multiple URLs for individual posts (GET variables, etc)
        // Possibly rework to include a unique post ID (or whatever)
        if ($recent) {
            foreach ($recent as $key => $val) {
                if ($val == $this->id)
                    unset($recent[$key]);
            }
        }

        // Push the current page into the recently viewed posts array
        $recent[time()] = $this->id;

        // If more than $num_to_store elements, then delete everything except the newest $num_to_store
        if (sizeof($recent) > $num_to_store) {
            // These are already in the correct order, but would theoretically be logical to sort by key here.
            $recent = array_slice($recent, sizeof($recent) - 5, sizeof($recent), true);
        }

        // Queue the updated "recently viewed" list to update on the user's next page load
        // I.e., don't show the current page as "recently viewed" until they navigate away from it (or otherwise refresh the page)
        \Cookie::queue('recently_viewed_events', json_encode($recent), $minutes_to_store);
    }

    // Добавляет эвент в избранное у текущего пользователя
    public function feature()
    {
        return $this->users_who_have_added_to_favorites()->toggle(Auth()->user());
    }

    public function scopeActive($query)
    {
        return $query->whereHas('company', function ($q) {
                $q->active();
            })
//            ->whereDate('start', '<=', date('Y-m-d'))
            ->where(function($q){
                $q->whereDate('end', '>=', date('Y-m-d'))
                ->orWhere('end', NULL);
            })
            ->where('active', true)
            ->where('published', true);
    }

    public function scopeCompleted($query)
    {
        return $query->whereHas('company', function ($q) {
                $q->active();
            })
//            ->whereDate('start', '<=', date('Y-m-d'))
            ->whereDate('end', '<', date('Y-m-d'));
    }

    public function scopeNoend($query)
    {
        return $query->whereHas('company', function ($q) {
                $q->active();
            })
//            ->whereDate('start', '<=', date('Y-m-d'))
            ->whereDate('end', NULL)
            ->where('active', true)
            ->where('published', true);
    }

    public function syncRating()
    {
        $ratingResultsCount = $this->rating_results->sum('count');
        if ($ratingResultsCount > 0) {
            $this->star = $this->rating_results->reduce(function ($carry, $item) {
                return $item->star * $item->count + $carry;
            }, 0) / $this->rating_results->sum('count');
        } else {
            $this->star = 0;
        }

        return $this->save();
    }

    public function syncRecommendation()
    {
        if ($this->recommendation_result) {
            $result = ($this->recommendation_result->positive + $this->recommendation_result->negative) * $this->recommendation_result->positive;
            if ($result == 0) {
                $this->rec = 0;
            } else {
                $this->rec = 100 / $result;
            }
        } else {
            $this->rec = 0;
        }

        return $this->save();
    }

    public function getRatingResultsArrayAttribute()
    {
        return $this->rating_results->mapWithKeys(function ($item) {
            return [$item['star'] => $item['count']];
        });
    }

    public function getCountStarsAttribute()
    {
        return $this->rating_results->sum('count');
    }

    public function getEventUrlAttribute()
    {
        return route('frontend.event.show', $this);
    }

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }
}
