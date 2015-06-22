<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model  implements AuthenticatableContract {

	use Authenticatable;

	protected $hidden = ['password', 'role_id'];
	
	public function role() {
		return $this->belongsTo('App\Role');
	}

	public function personable() {
		return $this->morphTo('personable');
	}

	public function notif() {
		return $this->hasMany('App\Notification');
	}

	public function getPersonableTypeAttribute($type) {
		$type = strtolower($type);
		return 'App\\'. str_replace(' ', '', ucwords($type));
	}

}
