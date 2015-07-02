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

	public static function now() {
		$year = date('Y');
		$month = date('m');
		$odd = 1;
		if ($month < 8 && $month > 1) {
			$year--;
			$odd--;
		}
		return static::firstOrCreate(compact('year', 'odd'));
	}

	public function toString() {
		return $this->year . '/'
			. ($this->year + 1) . ' '
			. ($this->odd == 1 ? 'Gasal' : 'Genap');
	}

}
