<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $fillable = ['start_date', 'end_date'];
	// protected $appends = ['status_string'];

	public function students() {
		return $this->belongsToMany('App\Student', 'members');
	}

	public function corporation() {
		return $this->belongsTo('App\Corporation');
	}

	public function grade() {
		return $this->hasOne('App\Grade');
	}

	public function mentor() {
		return $this->hasOne('App\Mentor');
	}

	public function lecturer() {
		return $this->belongsTo('App\Lecturer');
	}

	public function requests() {
		return $this->hasMany('App\GroupRequest');
	}

	// public function getStatusStringAttribute($status) {
	// 	return  $status == -1 ? 'deleted' :(
	// 			$status ==  0 ? 'created' :(
	// 			$status ==  1 ? 'confirmed' :(
	// 			$status ==  5 ? 'finished' :
	// 				'unknown')));
	// }

}
