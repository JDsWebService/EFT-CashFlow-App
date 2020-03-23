<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    // Define the Table Being Used
    protected $table = 'balance';

    // Define the Relationship with the User Model
    public function user() {
    	return $this->belongsTo('App\Models\User');
    }
}
