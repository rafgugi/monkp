<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\RedirectResponse;

class RedirectIfUser {

	/**
	 * This actually $user->role.
	 */
	protected $user;

	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = strtoupper($this->user);
		if (Auth::user()->role != $user) {
			return new RedirectResponse(url('/home'));
		}
		return $next($request);
	}

}
