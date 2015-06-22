<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/* Ini ngambil dari tabel yang dikasih pak Onggo */
class Lecturer extends Model {

	public $timestamps = false;

	public function user() {
		return $this->hasOne('App\User', 'personable_id');
	}

}
