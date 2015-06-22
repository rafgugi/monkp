<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

	protected $appends = ['name'];

	public $name = 'Admin';

}
