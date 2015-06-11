<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check()) {
			return $this->dashboard();
		}
		return view('home');
	}

	public function dashboard()
	{
		$student = Auth::user()->personable;
		$members = $student->members;

		$data = compact('members');
		return view('inside.dashboard', $data);
	}

}
