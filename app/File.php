<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class File extends Model {

	public $timestamps = false;
	protected $guarded = [];
	protected $appends = ['path'];

	/**
	 * Open the file as binary and return as a response.
	 *
	 * @return BinaryFileResponse
	 */
	public function binary() {
		return new BinaryFileResponse($this->path);
	}

	public function download() {
		$header = ['Content: ' . $this->mime];
		return new BinaryFileResponse($this->path, 200, $header);
	}

	public function getPathAttribute() {
		return storage_path() . '\upload\\' . $this->saved_name;
	}

}
