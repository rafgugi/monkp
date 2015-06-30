<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model {

	public $timestamps = false;
	protected $morphClass = "lecturer";

	public function user() {
		return $this->morphOne('App\User', 'personable');
	}

	public static function getDosen() {
		return static::where('nip', '!=', '0')->get();
	}

	public function groups() {
		return $this->hasMany('App\Group');
	}

	public function getNameAttribute($name) {
		return ucwords(strtolower($name));
	}

}
