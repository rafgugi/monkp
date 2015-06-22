<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	public $timestamps = false;

	public function members() {
		return $this->hasMany('App\Member');
	}

	public function user() {
		return $this->hasOne('App\User', 'personable_id');
	}

	public function groups() {
		return $this->belongsToMany('App\Group', 'members');
	}

}
