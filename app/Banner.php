<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
class Banner extends Model
{
    protected $fillable = ['start', 'end', 'link'];

    protected $dates = ['start', 'end'];

    public function download()
    {
        return $this->belongsTo(Download::class, 'download_id');
    }

    public function mobile()
    {
        return $this->belongsTo(Download::class, 'mobile_download_id');
    }

    public function place()
    {
        return $this->belongsTo(BannerPlace::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getDownloadUrlAttribute() {
        if (empty($this->download) || !Storage::exists($this->download->path)) {
            return 'http://via.placeholder.com/1170x195';
        }
        return Storage::url($this->download->path);
    }

    public function getMobileUrlAttribute() {
        if (empty($this->mobile) || !Storage::exists($this->mobile->path)) {
            return 'http://via.placeholder.com/315x222';
        }
        return Storage::url($this->mobile->path);
    }
}
