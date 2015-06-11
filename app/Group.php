<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $guarded = [];

	public function members() {
		return $this->hasMany('App\Members');
	}

	public function grade() {
		return $this->hasOne('App\Grade');
	}

	public function mentor() {
		return $this->hasOne('App\Mentor');
	}

	public function corporation() {
		return $this->belongsTo('App\Corporation');
	}

	public function lecturer() {
		return $this->belongsTo('App\Lecturer', 'internal_id');
	}

}
