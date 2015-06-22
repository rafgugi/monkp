<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\RedirectResponse;

class RedirectIfUser {

	/**
	 * This actually $user->personable_type.
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
		$user = $this->namespaced($this->user);
		if (Auth::user()->personable_type != $user) {
			return new RedirectResponse(url('/home'));
		}
		return $next($request);
	}

	public function namespaced($type, $namespace = 'App') {
		$type = strtolower($type);
		return $namespace.'\\'. str_replace(' ', '', ucwords($type));
	}

}
