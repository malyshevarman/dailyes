<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyGalleryItem extends Model
{
    protected $fillable = ['sort'];

    public function attachable()
    {
        return $this->morphTo();
    }
}
