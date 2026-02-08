<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyView extends Model
{
    protected $fillable = ['company_id', 'date', 'count'];
}
