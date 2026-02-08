<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportsAnswer extends Model
{
    protected $fillable = ['text'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
