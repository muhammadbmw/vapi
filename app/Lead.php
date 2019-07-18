<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
	public $timestamps = false;
	
	public function user(){
        return $this->belongsTo('App\User');
    }
	public function contacts(){
       return $this->hasMany('App\Contact','lid','id');
    }
   
}
