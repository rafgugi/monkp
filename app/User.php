<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model  implements AuthenticatableContract {

	use Authenticatable;

	protected $hidden = ['password', 'role_id'];
	protected $appends = ['role'];
	
	public function role() {
		if ($this->personable_type == 'App\Student') {
			return 'STUDENT';
		} else if ($this->personable_type == 'App\Lecturer') {
			if ($this->personable->nip == '0') {
				return 'ADMIN';
			} else {
				return 'DOSEN';
			}
		} else {
			return 'UNKNOWN';
		}
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
