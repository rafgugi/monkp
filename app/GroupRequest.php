<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupRequest extends Model {

	public $timestamps = false;

	public function group() {
		return $this->belongsTo('App\Group');
	}

	public function notif() {
		return $this->hasOne('App\Notification', 'notifiable_id');
	}

}
