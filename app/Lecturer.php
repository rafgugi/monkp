<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model {

	public $timestamps = false;
	protected $morphClass = "lecturer";

	public function getNameAttribute($name) {
		return ucwords(strtolower($name));
	}

	public function scopeDosen($q) {
		return $q->where('nip', '!=', '0');
	}

	public function user() {
		return $this->morphOne('App\User', 'personable');
	}

	public function groups() {
		return $this->hasMany('App\Group');
	}

}
