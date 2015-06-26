<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Lecturer;

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
		switch (Auth::user()->personable_type) {
			case 'App\Student':
				$student = Auth::user()->personable;
				$groups = $student->groups;

				$data = compact('groups');
				// dd($data);
				return view('inside.dashboardstudent', $data);
				break;
			case 'App\Lecturer':
				echo 'welcome lecturer';
				break;
			case 'App\Admin':
				return Auth::user()->personable->name;
				break;
			default:
				return view('home');
				break;
		}
	}

}
