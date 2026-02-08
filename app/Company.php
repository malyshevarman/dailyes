<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use Sluggable;
    use Notifiable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = ['name', 'slug', 'url', 'summary', 'about', 'published', 'rejected', 'message', 'active', 'image_download_id', 'background_download_id', 'verification_email'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $hidden = [
        'verify_token',
    ];

    protected $casts = [
        'published' => 'boolean',
        'rejected' => 'boolean',
        'active' => 'boolean',
    ];

    protected $appends = [
        // 'image_url', 
        // 'background_url', 
        // 'user_rating', 
        // 'user_recommendation'
    ];

//    protected $dispatchesEvents = [
//        'saved' => CompanyChanged::class,
//        'deleted' => CompanyDeleted::class,
//    ];
    public function changes_log() {
        return $this->hasMany(CompanyChangesLog::class);
    }

    public function changes_flags() {
        return $this->hasOne(CompanyChangesFlags::class);
    }
    // // TODO удалить отношение, так как создал просто categories
    // public function company_categories()
    // {
    //     return $this->belongsToMany(CompanyCategory::class, 'company_has_company_categories');
    // }

    // public function seo()
    // {
    //     return $this->morphOne(Seo::class, 'seoable');
    // }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(CategoriesTag::class, 'company_has_categories_tags');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function active_events()
    {
        return $this->hasMany(Event::class)->whereHas('addresses', function($q) {
            $q->where('city_id', city()->id);
        })->active();
    }

    public function completed_events()
    {
        return $this->hasMany(Event::class)->whereHas('addresses', function($q) {
            $q->where('city_id', city()->id);
        })->completed();
    }

    public function noend_events()
    {
        return $this->hasMany(Event::class)->noend();
    }

    public function views_today()
    {
        return $this->hasOne(CompanyView::class)->whereDate('date', date("Y-m-d"));
    }

    public function views_weekly()
    {
        return $this->hasMany(CompanyView::class)->whereDate('date', '>=', date("Y-m-d", strtotime("-7 day")));
    }

    public function rating()
    {
        return $this->hasOne(CompanyRating::class);
    }

    public function gallery_items()
    {
        return $this->morphMany(GalleryItem::class, 'model');
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
        return $this->belongsToMany(User::class, 'user_has_favorite_companies', 'company_id', 'user_id')->withTimestamps();
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
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image) || !Storage::exists($this->image->path)) {
            return 'http://via.placeholder.com/285x300';
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

    // Добавляет компанию в избранное у текущего пользователя
    public function feature()
    {
        return $this->users_who_have_added_to_favorites()->toggle(Auth()->user());
    }

    public function scopeActive($query)
    {
        return $query
            ->where('published', 1)
            ->where('rejected', 0)
            ->where('active', 1);
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

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->verification_email;
    }
}
