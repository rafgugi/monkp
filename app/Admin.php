<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

	protected $table = '';
	protected $appends = ['name'];
	public $getNameAttribute() { return 'Koor KP'; }

}
