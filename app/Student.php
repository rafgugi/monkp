<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	public function members() {
		return $this->hasMany('App\Member');
	}

	public function user() {
		return $this->morphMany('App\User', 'personable');
	}

}
