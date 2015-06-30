<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model {

	protected $table = 'semesters';
	public $timestamps = false;
	protected $guarded = [];

	public function groups() {
		return $this->HasMany('App\Group');
	}

	public static function latest() {
		return static::orderBy('id', 'desc')->first();
	}

	public function toString() {
		return $this->year . '/'
			. ($this->year + 1) . ' '
			. ($this->odd == 1 ? 'Gasal' : 'Genap');
	}

}
