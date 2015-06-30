<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model {

	public function member() {
		return $this->belongsTo('App\Member');
	}

}
