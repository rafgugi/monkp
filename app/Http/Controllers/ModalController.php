<?php namespace App\Http\Controllers;

use App\Corporation;

class ModalController extends Controller {

	public function getPerusahaan() {
		return view('modal.corporation');
	}
}