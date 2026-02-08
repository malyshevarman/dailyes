<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    public function attachable()
    {
        return $this->morphTo();
    }

    public function model()
    {
        return $this->morphTo();
    }
}
