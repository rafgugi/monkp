<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inside.user');
	}

	/**
	 * Store a student in storage.
	 *
	 * @return Response
	 */
	public function student()
	{
		//
	}

	/**
	 * Store a lecturer in storage.
	 *
	 * @return Response
	 */
	public function lecturer()
	{
		//
	}

}
