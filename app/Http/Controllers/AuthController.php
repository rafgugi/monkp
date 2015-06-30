<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\Student;

class AuthController extends Controller {

	/**
	 * The Guard implementation. See Illuminate\Auth\Guard.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->auth = $auth;
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return redirect('home');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'username' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('username', 'password');
		if ($this->auth->attempt($credentials, false))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect()->back()
				->withInput($request->only('username'))
				->withErrors([
					'username' => 'Incorrect username and/or password.',
				]);
	}

	/**
	 * Show the application register form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return view('register');
	}

	/**
	 * Handle a register request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'nrp' => 'required|numeric|unique:users,username',
			'password' => 'required|same:password_confirmation',
		]);

		# make student
		$student = new Student();
		$student->nrp = $request->input('nrp');
		$student->name = $request->input('name');
		$student->save();

		# make user
		$user = new User();
		$user->username = $request->input('nrp');
		$user->password = bcrypt($request->input('password'));

		# attach student to user
		$user->personable_id = $student->id;
		$user->personable_type = 'student';
		$user->save();

		$this->auth->login($user);

		return redirect($this->redirectPath());
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();
		return redirect('/');
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
	}

}
