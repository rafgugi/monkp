<?php namespace App\Http\Controllers;

use App\Corporation;

class ModalController extends Controller {

	public function getPerusahaan($id) {
		$corp = Corporation::with('groups.students')->find($id);
		return view('modal.corporation', compact('corp'));
	}
}