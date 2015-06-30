<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Lecturer;
use App\Group;
use App\Member;
use App\Corporation;

class HomeController extends Controller {

	/**
	 * Display either login page or groups listing.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check()) {
			return $this->groups();
		}
		return view('home');
	}

	/**
	 * Display groups listing.
	 *
	 * @return Response
	 */
	public function groups()
	{
		$lecturers = Lecturer::getDosen()->sortBy('initial');
		switch (Auth::user()->role) {
			case 'STUDENT':
				$student = Auth::user()->personable;
				$groups = $student->groups;

				$data = compact('groups', 'lecturers');
				return view('inside.kelompok', $data);
				break;
			case 'LECTURER':
				echo 'welcome lecturer';
				break;
			case 'ADMIN':
				$student = Auth::user()->personable;
				$groups = Group::get();

				$data = compact('groups', 'lecturers');
				return view('inside.kelompok', $data);
				break;
			default:
				return view('home');
				break;
		}
	}

	public function stats() {
		$groups = Group::get();
		$corps = Corporation::get()->sortBy(
			function($s) {return $s->groups->count();}
		)->reverse();
		$dosens = Lecturer::getDosen()->take(10)->sortBy(
			function($s) {return $s->groups->count();}
		)->reverse();
		$data = compact('groups', 'corps', 'dosens');
		return view('inside.statistic', $data);
	}

	public function table() {
		$members = Member::get();
		$data = compact('members');
		return view('inside.table', $data);
	}

}
