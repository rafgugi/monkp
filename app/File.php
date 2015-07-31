<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class File extends Model {

	public $timestamps = false;
	protected $guarded = [];
	protected $appends = ['path'];
	protected $download_path = 'storage/upload/';

	public function download() {
		return redirect($this->path);
	}

	public function getPathAttribute() {
		return $this->download_path . $this->saved_name;
	}

}
