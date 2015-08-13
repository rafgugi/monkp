<?php namespace App\Http\Controllers;

use App\User;
use App\Corporation;
use App\Student;

class DummyController extends Controller {

	public function index()
	{
		// Mahasiswa, User, perusahaan, 
		$perusahaan = [
			[
				'name' => '',
				'address' => '',
				'city' => '',
				'business_type' => '',
				'description' => ''
			],
		];

		$student = [
			[
				'nrp' => '',
				'name' => ''
			],
		];
	}

}
