<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyChangesLog extends Model
{
    protected $table = 'company_changes_log';

    protected $fillable = ['company_id', 'user_id', 'original_data', 'changed_data', 'route'];

    protected $casts = [
        'original_data' => 'array',
        'changed_data' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
