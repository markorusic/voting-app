<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{

	protected $fillable = ['title'];

    public function choices()
    {
    	return $this->hasMany('App\Choice');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function votes()
    {
    	return $this->hasMany('App\Votes');    	
    }
}
