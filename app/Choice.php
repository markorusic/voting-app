<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{

	protected $fillable = ['title'];

    public function poll()
    {
    	return $this->belongsTo('App\Poll');
    }
}
