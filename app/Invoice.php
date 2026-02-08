<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	$fillable = ['amount',
				'currency',
				'description',
				'message'
			];
			
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
